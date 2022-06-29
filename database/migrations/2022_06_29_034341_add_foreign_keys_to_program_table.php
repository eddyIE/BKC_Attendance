<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProgramTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('program', function(Blueprint $table)
		{
			$table->foreign('major_id', 'fk_session_major_id')->references('id')->on('major')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'fk_session_user_create')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('modified_by', 'fk_session_user_modifiy')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('program', function(Blueprint $table)
		{
			$table->dropForeign('fk_session_major_id');
			$table->dropForeign('fk_session_user_create');
			$table->dropForeign('fk_session_user_modifiy');
		});
	}

}
