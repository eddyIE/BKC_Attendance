<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMajorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('major', function(Blueprint $table)
		{
			$table->foreign('program_id', 'fk_major_program_id')->references('id')->on('program')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'fk_major_user_create')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('modified_by', 'fk_major_user_modifiy')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('major', function(Blueprint $table)
		{
			$table->dropForeign('fk_major_program_id');
			$table->dropForeign('fk_major_user_create');
			$table->dropForeign('fk_major_user_modifiy');
		});
	}

}
