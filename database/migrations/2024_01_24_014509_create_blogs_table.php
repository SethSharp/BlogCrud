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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id');
            $table->boolean('is_draft');
            $table->string('title');
            $table->string('slug');
            $table->string('meta_title')->nullable()->default('');
            $table->string('meta_description')->nullable()->default('');
            $table->string('meta_tags')->nullable()->default('');
            $table->text('content');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
