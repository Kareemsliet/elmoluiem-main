<?php

use App\Enums\CourseTypesEnums;
use App\Enums\GenderTypesEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration {

	public function up()
	{
		Schema::create('teachers', function(Blueprint $table) {
			$table->id();
			$table->string('name', 255);
			$table->string('email')->unique();
			$table->string('password');
			$table->string('phone', 255);
			$table->string('address', 255)->nullable();
			$table->string('profile_image', 255)->nullable();
			$table->integer('experince')->nullable();
			$table->string("gender")->default(GenderTypesEnums::Male->value);
			$table->string('qualification', 255)->nullable();
			$table->text("description")->nullable();
			$table->bigInteger('education_level_id')->unsigned();
			$table->foreign("education_level_id")->references("id")->on("education_levels")->onDelete("cascade")->onUpdate("cascade");
			$table->string('cv', 255)->nullable();
			$table->timestamp("email_verified_at")->nullable();
			$table->string('course_type')->default(CourseTypesEnums::General->value);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('teachers');
	}
}
