<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_metas', function (Blueprint $table) {
            $table->id();
            $table->text('rate')->nullable();
            $table->text('property')->nullable();
            $table->string('titleEn')->nullable();
            $table->text('ability')->nullable();
            $table->string('guarantee')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });
        Schema::create('post_metables', function (Blueprint $table) {
            $table->integer('post_meta_id');
            $table->integer('post_metables_id');
            $table->string('post_metables_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_metas');
    }
}
