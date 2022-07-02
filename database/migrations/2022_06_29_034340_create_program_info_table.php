<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_info', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('program_id')->index('fk_subject_program_id')->comment('chương trình học');
			$table->integer('subject_id')->index('fk_subject_subject_id')->comment('tên môn');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_subject_user_create');
			$table->integer('modified_by')->nullable()->index('fk_subject_user_modifiy');
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
		Schema::drop('program_info');
	}

}
