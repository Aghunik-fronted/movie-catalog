<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'title' => 'Интерстеллар',
            'description' => 'Когда наше время на Земле подходит к концу, команда исследователей отправляется в самую важную миссию в истории человечества: путешествие за пределы нашей галактики, чтобы узнать, есть ли у человечества будущее среди звезд.',
            'poster' => 'posters/interstellar.webp'
        ]);

        Movie::create([
            'title' => 'Начало',
            'description' => 'Кобб — талантливый вор, лучший в опасном искусстве извлечения: он крадет ценные секреты из глубин подсознания во время сна, когда человеческий разум наиболее уязвим.',
            'poster' => 'posters/inception.webp'
        ]);

        Movie::create([
            'title' => 'Матрица',
            'description' => 'Жизнь Томаса Андерсона разделена на две части: днем он самый обычный программист, а ночью — хакер Нео. Но однажды всё меняется, когда он узнает страшную правду о реальности.',
            'poster' => 'posters/matrix.webp'
        ]);

        Movie::create([
            'title' => 'Темный рыцарь',
            'description' => 'Бэтмен поднимает ставки в войне с криминалом. С помощью лейтенанта Джима Гордона и прокурора Харви Дента он намерен очистить улицы Готэма от преступности, пока там не появляется Джокер.',
            'poster' => 'posters/dark_knight.webp'
        ]);
    }
}
