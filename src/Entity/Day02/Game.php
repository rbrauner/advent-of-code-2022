<?php

declare(strict_types=1);

namespace App\Entity\Day02;

class Game
{
    public function __construct(
        private string $elf,
        private string $you,
    )
    {
    }

    public function calculateScore(): int
    {
    }
}