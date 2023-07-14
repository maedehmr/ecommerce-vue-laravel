<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->text('rate')->nullable();
            $table->text('bad')->nullable();
            $table->text('good')->nullable();
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('status' , 1)->default(0);
            $table->string('parent_id' , 10)->default(0);
            $table->boolean('seen')->default(0);
            $table->boolean('approved')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
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
        Schema::dropIfExists('comments');
    }
}
