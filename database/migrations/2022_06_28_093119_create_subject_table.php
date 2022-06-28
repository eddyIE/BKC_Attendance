<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('program_id')->index('fk_subject_program_id')->comment('chương trình học');
			$table->string('name')->comment('tên môn');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_subject_user_create');
			$table->integer('modified_by')->nullable()->index('fk_subject_user_modifiy');
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
		Schema::drop('subject');
	}

}
