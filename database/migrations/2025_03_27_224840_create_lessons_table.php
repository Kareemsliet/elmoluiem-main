<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration {
	public function up()
	{
		Schema::create('lessons', function(Blueprint $table) {
			$table->id('id');
			$table->timestamps();
			$table->bigInteger('teacher_id')->unsigned();
			$table->foreign("teacher_id")->references("id")->on("teachers")->onDelete("cascade")->onUpdate("cascade");
			$table->decimal('price')->nullable()->default('0.0');
			$table->string("logo");
			$table->string('title', 255);
			$table->text('description')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('lessons');
	}
}
