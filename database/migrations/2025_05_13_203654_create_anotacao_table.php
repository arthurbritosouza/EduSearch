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
        Schema::create('anotacao', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('fk_anotacao_user');
            $table->integer('id_topic')->index('fk_anotacao_topic');
            $table->string('titulo', 244);
            $table->text('anotacao');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anotacao');
    }
};
