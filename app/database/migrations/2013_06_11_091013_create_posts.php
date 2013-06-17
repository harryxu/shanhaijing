<?php

use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function($table) 
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('topic_id');
            $table->text('body');
            $table->integer('type')->default(1);
            $table->datetime('created_at');
            $table->datetime('updated_at');

            $table->index(array('topic_id', 'type', 'created_at'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }

}
