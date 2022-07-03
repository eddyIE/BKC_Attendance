<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('username')->unique('UNIQUE')->comment('tên đăng nhập');
			$table->string('password')->comment('mật khẩu');
			$table->integer('role')->nullable()->default(0)->comment('chức vụ (0: giảng viên, 1: giáo vụ, 2: trưởng giáo vụ)');
			$table->string('full_name')->comment('họ & tên');
			$table->integer('phone')->nullable()->comment('số điện thoại');
			$table->boolean('gender')->comment('giới tính');
			$table->boolean('status')->nullable()->default(1);
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
		Schema::drop('user');
	}

}
