<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title');
            $table->text('image');
            $table->string('slug');
            $table->string('count' , 5);
            $table->string('code' , 20);
            $table->boolean('status');
            $table->boolean('showcase')->default(0);
            $table->boolean('original')->default(1);
            $table->boolean('used')->default(0);
            $table->string('suggest')->nullable();
            $table->string('off' , 3)->nullable();
            $table->text('summery')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('price');
            $table->string('offPrice' , 25)->nullable();
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
