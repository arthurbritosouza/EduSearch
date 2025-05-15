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
        Schema::table('relacione', function (Blueprint $table) {
            $table->foreign(['id_dono'], 'fk_relacione_dono')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_parceiro'], 'fk_relacione_parceiro')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_topic'], 'fk_relacione_topic')->references(['id'])->on('topic_folder')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'fk_relacione_user')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relacione', function (Blueprint $table) {
            $table->dropForeign('fk_relacione_dono');
            $table->dropForeign('fk_relacione_parceiro');
            $table->dropForeign('fk_relacione_topic');
            $table->dropForeign('fk_relacione_user');
        });
    }
};
