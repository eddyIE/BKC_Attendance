<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course', function(Blueprint $table)
		{
			$table->foreign('class_id', 'fk_course_class_id')->references('id')->on('class')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('subject_id', 'fk_course_subject_id')->references('id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'fk_course_user_create')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('modified_by', 'fk_course_user_modify')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course', function(Blueprint $table)
		{
			$table->dropForeign('fk_course_class_id');
			$table->dropForeign('fk_course_subject_id');
			$table->dropForeign('fk_course_user_create');
			$table->dropForeign('fk_course_user_modify');
		});
	}

}
