<?php

namespace App\Enum;

enum MusicGenre: string
{
    case Pop = 'Pop';
    case Rock = 'Rock';
    case Alternative = 'Alternative';
    case Indie = 'Indie';
    case Metal = 'Metal';
    case Punk = 'Punk';
    case Jazz = 'Jazz';
    case Blues = 'Blues';
    case Classical = 'Classical';
    case HipHop = 'Hip Hop';
    case Rap = 'Rap';
    case RnB = 'R&B';
    case Soul = 'Soul';
    case Funk = 'Funk';
    case Electronic = 'Electronic';
    case NewAGE = 'New Age';
    case Reggaeton = 'Reggaeton';
    public static function getAllGenres(): array
    {
        return array_map(fn ($genre) => $genre, self::cases());
    }
}
