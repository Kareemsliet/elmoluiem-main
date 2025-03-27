<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationSystemsTable extends Migration {

	public function up()
	{
		Schema::create('education_systems', function(Blueprint $table) {
			$table->id('id');
			$table->string('name', 255);
			$table->bigInteger('country_id')->unsigned();
			$table->foreign("country_id")->references("id")->on("countries")->onDelete("cascade")->onUpdate("cascade");
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('education_systems');
	}
}
