<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('lecturer_id')->index('fk_lesson_lecturer_id')->comment('giảng viên');
			$table->integer('course_id')->index('fk_lesson_course_id')->comment('khóa học');
			$table->time('start')->comment('thời gian bắt đầu buổi học');
			$table->time('end')->comment('thời gian kết thúc buổi học');
			$table->string('note')->nullable()->comment('ghi chú');
			$table->integer('created_by')->index('fk_lesson_user_create');
			$table->integer('modified_by')->nullable()->index('fk_lesson_user_modifiy');
            $table->timestamps($precision = 0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lesson');
	}

}
