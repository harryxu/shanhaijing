<?php

use Illuminate\Database\Migrations\Migration;

class CreateTopics extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function($table) 
        {
            $table->increments('id');
            $table->string('title');
            $table->integer('user_id');
            $table->integer('first_post_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics');
    }

}
