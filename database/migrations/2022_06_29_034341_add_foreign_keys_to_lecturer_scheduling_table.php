<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToLecturerSchedulingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lecturer_scheduling', function(Blueprint $table)
		{
			$table->foreign('course_id', 'fk_substitue_course_id')->references('id')->on('course')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('lecturer_id', 'fk_substitue_lecturer_id')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'fk_substitue_user_create')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('modified_by', 'fk_substitue_user_modifiy')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lecturer_scheduling', function(Blueprint $table)
		{
			$table->dropForeign('fk_substitue_course_id');
			$table->dropForeign('fk_substitue_lecturer_id');
			$table->dropForeign('fk_substitue_user_create');
			$table->dropForeign('fk_substitue_user_modifiy');
		});
	}

}
