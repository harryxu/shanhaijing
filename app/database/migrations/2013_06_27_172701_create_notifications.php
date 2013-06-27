<?php

use Illuminate\Database\Migrations\Migration;

class CreateNotifications extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function($table) 
        {
            $table->increments('id');
            $table->integer('user_id')->index();

            // Notify type: new reply, mentions, etc.
            $table->string('type', 30); 

            // Notify item id like topic id, post id.
            $table->integer('item_id')->nullable(); 

            // Short notify msg.
            $table->string('msg'); 

            $table->datetime('created_at');
            $table->boolean('readed')->default(false);

            // Extra data.
            $table->text('data')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }

}
