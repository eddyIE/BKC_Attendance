<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('class_id')->nullable()->index('fk_course_class_id')->comment('lớp');
			$table->integer('subject_id')->nullable()->index('fk_course_subject_id')->comment('môn');
			$table->string('name')->comment('tên khóa học');
			$table->decimal('total_hours', 10)->comment('tổng thời gian khóa học');
            $table->decimal('finished_hours', 10)->nullable()->comment('số giờ đã dạy');
            $table->integer('finished_lessons')->nullable()->comment('số buổi đã dạy');
			$table->string('scheduled_day')->nullable()->comment('lịch dạy theo số buổi trong tuần');
			$table->string('scheduled_time')->nullable()->comment('lịch dạy theo giờ');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_course_user_create');
			$table->integer('modified_by')->nullable()->index('fk_course_user_modify');
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
		Schema::drop('course');
	}

}
