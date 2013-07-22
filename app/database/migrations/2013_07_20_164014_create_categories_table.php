<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function($table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('description');
            $table->string('color', 6);
            $table->string('logo')->nullable();
            $table->integer('user_id');
            $table->integer('topic_count')->default(0);
            $table->string('slug')->unique();
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->integer('weight')->default(0);

            $table->index('weight');
        });

        // Add category_id to topics table.
        Schema::table('topics', function($table)
        {
            $table->integer('category_id')->default(0)->after('first_post_id');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');

        Schema::table('topics', function($table)
        {
            $table->dropIndex('category_id_index');
            $table->dropColumn('category_id');
        });
    }

}
