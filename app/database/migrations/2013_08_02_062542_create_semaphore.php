<?php

use Illuminate\Database\Migrations\Migration;

class CreateSemaphore extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('semaphore', function($table)
        {
            $table->string('name', 255);
            $table->string('value', 255);
            $table->decimal('expire', 14, 4);
            $table->primary('name');
            $table->index('value');
            $table->index('expire');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('semaphore');
	}

}
