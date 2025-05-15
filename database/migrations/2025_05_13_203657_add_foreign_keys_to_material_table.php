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
        Schema::table('material', function (Blueprint $table) {
            $table->foreign(['id_topic'], 'fk_material_topic')->references(['id'])->on('topic_folder')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'fk_material_user')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material', function (Blueprint $table) {
            $table->dropForeign('fk_material_topic');
            $table->dropForeign('fk_material_user');
        });
    }
};
