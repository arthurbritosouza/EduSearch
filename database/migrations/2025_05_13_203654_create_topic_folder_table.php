<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('topic_folder', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('fk_topic_folder_user');
            $table->string('name', 244);
            $table->string('materia', 100);
            $table->text('resumo');
            $table->text('sobre');
            $table->text('topics');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_folder');
    }
};
