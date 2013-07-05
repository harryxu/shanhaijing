<?php

use Illuminate\Database\Migrations\Migration;

class CreateTopicUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_users', function($table) {
            $table->increments('id');
            $table->integer('topic_id');
            $table->integer('user_id');
            $table->boolean('starred')->default(false);
            $table->datetime('starred_at')->nullable();
            $table->boolean('watching')->default(false);

            $table->unique(array('topic_id', 'user_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topic_users');
    }

}
