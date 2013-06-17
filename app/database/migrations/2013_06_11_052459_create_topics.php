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
            $table->integer('posts_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->datetime('last_post_at');
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
