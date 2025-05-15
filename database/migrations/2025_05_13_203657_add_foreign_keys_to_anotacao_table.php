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
        Schema::table('anotacao', function (Blueprint $table) {
            $table->foreign(['id_topic'], 'fk_anotacao_topic')->references(['id'])->on('topic_folder')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'fk_anotacao_user')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anotacao', function (Blueprint $table) {
            $table->dropForeign('fk_anotacao_topic');
            $table->dropForeign('fk_anotacao_user');
        });
    }
};
