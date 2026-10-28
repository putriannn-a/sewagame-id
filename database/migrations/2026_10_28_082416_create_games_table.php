<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel platforms
            $table->foreignId('platform_id')->constrained('platforms')->onDelete('restrict');
            $table->string('title');
            $table->enum('condition', ['bnib', 'like_new', 'good'])->default('good');
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('rent_daily_price', 12, 2);
            $table->decimal('deposit_amount', 12, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};