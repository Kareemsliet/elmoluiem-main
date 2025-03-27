<?php

use App\Enums\GenderTypesEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilesTable extends Migration
{
	public function up()
	{
		Schema::create('familes', function (Blueprint $table) {
			$table->id();
			$table->string('name', 255);
			$table->string('password');
			$table->string('email');
			$table->timestamp("email_verified_expired")->nullable();
			$table->string('phone')->nullable();
			$table->string("gender")->default(GenderTypesEnums::Male->value);
			$table->timestamp("email_verified_at")->nullable();
			$table->string("email_verified_code")->nullable();
			$table->bigInteger('education_level_id')->unsigned();
			$table->foreign("education_level_id")->references("id")->on("education_levels")->onDelete("cascade")->onUpdate("cascade");
			$table->string('profile_image')->nullable();
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::drop('familes');
	}
}
