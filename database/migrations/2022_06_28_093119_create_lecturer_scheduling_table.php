<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerSchedulingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lecturer_scheduling', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('course_id')->index('fk_substitue_course_id')->comment('khóa học');
			$table->integer('lecturer_id')->index('fk_substitue_lecturer_id')->comment('giảng viên');
			$table->integer('lesson_taught')->nullable()->comment('số buổi dạy');
			$table->boolean('substitution')->nullable()->default(0)->comment('dạy thay (0: không/1: có)');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_substitue_user_create');
			$table->integer('modified_by')->nullable()->index('fk_substitue_user_modifiy');
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
		Schema::drop('lecturer_scheduling');
	}

}
