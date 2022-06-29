<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAttendanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attendance', function(Blueprint $table)
		{
			$table->foreign('lesson_id', 'fk_attendance_lesson_id')->references('id')->on('lesson')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('student_id', 'fk_attendance_student_id')->references('id')->on('student')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'fk_attendance_user_create')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('modified_by', 'fk_attendance_user_modify')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attendance', function(Blueprint $table)
		{
			$table->dropForeign('fk_attendance_lesson_id');
			$table->dropForeign('fk_attendance_student_id');
			$table->dropForeign('fk_attendance_user_create');
			$table->dropForeign('fk_attendance_user_modify');
		});
	}

}
