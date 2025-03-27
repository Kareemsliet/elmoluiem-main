<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration {

	public function up()
	{
		Schema::create('subjects', function(Blueprint $table) {
			$table->id("id");
			$table->string('name');
			$table->bigInteger('education_level_id')->unsigned();
			$table->foreign("education_level_id")->references("id")->on("education_levels")->onDelete("cascade")->onUpdate("cascade");
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('subjects');
	}
}
