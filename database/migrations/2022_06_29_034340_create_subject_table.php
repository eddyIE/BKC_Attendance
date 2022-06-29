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
			$table->string('name')->comment('tên môn');
			$table->integer('recommend_hours')->comment('thời gian dự kiến của môn');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by');
			$table->integer('modified_by')->nullable();
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
