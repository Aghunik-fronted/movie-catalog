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
    Schema::create('favorites', function (Blueprint $table) {
        $table->id();
        // Связываем с пользователем (если удалить юзера, удалится и его избранное)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // Связываем с фильмом (если удалить фильм, он исчезнет из избранного)
        $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
        $table->timestamps();

        // Уникальный индекс, чтобы нельзя было добавить один фильм в избранное дважды
        $table->unique(['user_id', 'movie_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
