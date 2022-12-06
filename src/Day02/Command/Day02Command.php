<?php

namespace App\Day02\Command;

use App\Common\Command\CommonDayCommand;
use SplFileObject;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
name: 'app:day02',
description: 'Day 02',
)]
class Day02Command extends CommonDayCommand
{
    protected const DAY = "02";

    protected int $elfScore = 0;
    protected int $yourScore = 0;

    protected function common(): void
    {
        $file = new SplFileObject($this->inputFilename, "r");
        while (!$file->eof()) {
            $line = $file->current();
            preg_match("/(?<elf>\w) (?<you>\w)/", $line, $matches);

            $file->next();
        }

    }

    protected function part1(): void
    {
    }

    protected function part2(): void
    {
    }
}