<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('class', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('program_id')->index('fk_class_session_id')->comment('chương trình học');
			$table->string('name')->comment('tên lớp');
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->index('fk_class_user_create');
			$table->integer('modified_by')->nullable()->index('fk_class_user_modify');
			$table->timestamp('create')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('modify')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('class');
	}

}
