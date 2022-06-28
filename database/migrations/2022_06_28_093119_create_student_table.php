<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('class_id')->nullable()->index('fk_student_class_id')->comment('lớp');
			$table->string('full_name')->comment('họ & tên');
			$table->date('birthdate')->nullable()->comment('ngày sinh');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_student_user_create');
			$table->integer('modified_by')->nullable()->index('fk_student_user_modifiy');
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
		Schema::drop('student');
	}

}
