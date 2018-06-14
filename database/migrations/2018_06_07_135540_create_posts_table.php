<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigInteger('id', 20);
            $table->string('slug', 100);
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->bigInteger('comment_id');
            $table->string('title', 100);
            $table->longText('content');
            $table->string('image', 50)->nullable();
            $table->text('seo');
            $table->string('keyword');
            $table->tinyInteger('status');
            $table->integer('view')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
