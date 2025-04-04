<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UniqueColumnById implements Rule
{
    protected $exceptId;

    protected $table;

    protected $relationTable;

    protected $relationColumn;

    protected $column;

    public function __construct($table,$column,$relationTable,$relationColumn,$exceptId=null){
    
        $this->table=$table;
    
        $this->column=$column;
    
        $this->relationTable=$relationTable;
    
        $this->relationColumn=$relationColumn;
    
        $this->exceptId=$exceptId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value):bool
    {
        return !DB::table($this->table)
        ->when($this->exceptId,function($query){
            $query->where($this->table.".id",'!=',$this->exceptId);
        })
        ->join($this->relationTable,$this->relationTable.".id",'=',$this->table.".".$this->relationColumn)
        ->where($this->table.'.'.$this->column,"=",$value)
        ->exists();
    }

    public function message(){
        return __("validation.unique");
    }
}
