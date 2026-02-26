<?php

namespace App\Enums;

enum LotteriesEnum: string
{
    case MEGA_SENA = 'mega-sena';
    case LOTOFACIL = 'lotofacil';
    case QUINA = 'quina';
    // case LOTOMANIA = 'lotomania';
    case TIMEMANIA = 'timemania';
    case DUPLA_SENA = 'dupla-sena';
    case DIA_DE_SORTE = 'dia-de-sorte';
    case MAIS_MILIONARIA = 'mais-milionaria';

    public function id(): int
    {
        return match ($this) {
            static::MEGA_SENA => 1,
            static::LOTOFACIL => 2,
            static::QUINA => 3,
            // static::LOTOMANIA => 4,
            static::TIMEMANIA => 5,
            static::DUPLA_SENA => 6,
            static::DIA_DE_SORTE => 7,
            static::MAIS_MILIONARIA => 8,
        };
    }

    public function label(): string
    {
        return match ($this) {
            static::MEGA_SENA => 'Mega Sena',
            static::LOTOFACIL => 'Lotofácil',
            static::QUINA => 'Quina',
            // static::LOTOMANIA => 'Lotomania',
            static::TIMEMANIA => 'Timemania',
            static::DUPLA_SENA => 'Dupla Sena',
            static::DIA_DE_SORTE => 'Dia de Sorte',
            static::MAIS_MILIONARIA => '+Milionária',
        };
    }

    public function numbersPerDraw(): int
    {
        return match ($this) {
            static::MEGA_SENA => 6,
            static::LOTOFACIL => 15,
            static::QUINA => 5,
            // static::LOTOMANIA => 20,
            static::TIMEMANIA => 7,
            static::DUPLA_SENA => 6,
            static::DIA_DE_SORTE => 7,
            static::MAIS_MILIONARIA => 6,
        };
    }

    public function numbersPerLine(): int
    {
        return match ($this) {
            static::MEGA_SENA => 10,
            static::LOTOFACIL => 5,
            static::QUINA => 10,
            // static::LOTOMANIA => 10,
            static::TIMEMANIA => 10,
            static::DUPLA_SENA => 10,
            static::DIA_DE_SORTE => 10,
            static::MAIS_MILIONARIA => 5,
        };
    }

    public function minNumber(): int
    {
        return match ($this) {
            // static::LOTOMANIA => 0,
            default => 1
        };
    }

    public function maxNumber(): int
    {
        return match ($this) {
            static::MEGA_SENA => 60,
            static::LOTOFACIL => 25,
            static::QUINA => 80,
            // static::LOTOMANIA => 99,
            static::TIMEMANIA => 80,
            static::DUPLA_SENA => 50,
            static::DIA_DE_SORTE => 31,
            static::MAIS_MILIONARIA => 50,
        };
    }
}
