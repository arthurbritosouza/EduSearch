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
        Schema::create('relacione', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('fk_relacione_user');
            $table->integer('id_topic')->index('fk_relacione_topic');
            $table->integer('id_dono')->index('fk_relacione_dono');
            $table->integer('id_parceiro')->index('fk_relacione_parceiro');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relacione');
    }
};
