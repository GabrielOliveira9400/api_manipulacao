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
        Schema::create('formula_ativos', function (Blueprint $table) {
            $table->id()->autoIncrement()->index()->primary();
            $table->foreignId('formula_id')->constrained()->onDelete('cascade');
            $table->foreignId('ativo_id')->constrained()->onDelete('cascade');
            $table->decimal('percentual', 5, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_ativos');
    }
};
