<?php

use App\Enums\GenderTypesEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration {

	public function up()
	{
		Schema::create('students', function(Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->string('name', 255);
			$table->string('email');
			$table->string('password', 255);
			$table->string('phone', 255)->nullable();
			$table->string('address', 255)->nullable();
			$table->timestamp("email_verified_at")->nullable();
			$table->timestamp("email_verified_expired")->nullable();
			$table->timestamp("reset_password_expired")->nullable();
			$table->string("gender")->default(GenderTypesEnums::Male->value);
			$table->text("description")->nullable();
			$table->string("reset_password_code")->nullable();
			$table->string("email_verified_code")->nullable();
			$table->bigInteger('education_level_id')->unsigned();
			$table->foreign("education_level_id")->references("id")->on("education_levels")->onDelete("cascade")->onUpdate("cascade");
			$table->string('profile_image', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('students');
	}
}
