<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->nullable()->comment('tên chương trình');
			$table->string('session')->comment('niên khóa');
			$table->date('start')->comment('năm học (bắt đầu)');
			$table->date('end')->comment('năm học (kết thúc)');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_session_user_create');
			$table->integer('modified_by')->nullable()->index('fk_session_user_modifiy');
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
		Schema::drop('program');
	}

}
