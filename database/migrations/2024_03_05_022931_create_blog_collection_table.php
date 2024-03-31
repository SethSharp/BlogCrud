<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id');
            $table->foreignId('collection_id');
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();
        });
    }
};
