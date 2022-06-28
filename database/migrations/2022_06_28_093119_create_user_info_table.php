<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_info', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('fk_user_info_user_id')->comment('tài khoản');
			$table->string('full_name')->comment('họ & tên');
			$table->string('title')->nullable()->comment('chức danh');
			$table->integer('phone')->nullable()->comment('số điện thoại');
			$table->boolean('gender')->comment('giới tính');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_info');
	}

}
