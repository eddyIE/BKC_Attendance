<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendance', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('lesson_id')->index('fk_attendance_lesson_id')->comment('buổi học');
			$table->integer('student_id')->index('fk_attendance_student_id')->comment('sinh viên');
			$table->string('attendant_status')->comment('tình trạng đi học (có mặt, nghỉ không phép, có phép, muộn)');
			$table->string('note')->nullable()->comment('lí do (nếu có)');
			$table->integer('created_by')->index('fk_attendance_user_create');
			$table->integer('modified_by')->nullable()->index('fk_attendance_user_modify');
			$table->timestamp('date_create')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('date_modify')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attendance');
	}

}
