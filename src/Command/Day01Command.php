<?php

namespace App\Command;

use App\Entity\Day01\Elf;
use SplFileObject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
name: 'app:day01',
description: 'Day 01',
)]
class Day01Command extends Command
{
    private string $inputFilename;
    private SymfonyStyle $io;
    private array $elves = [];

    public function __construct(string $name = null, KernelInterface $kernel = null)
    {
        parent::__construct($name);
        $this->inputFilename = $kernel->getProjectDir() . "/data/01/input.txt";
    }

    protected function configure(): void
    {
        $this
            ->addOption('part', 'p', InputOption::VALUE_REQUIRED, 'Part of day')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $part = (int) $input->getOption('part');
        if (!in_array($part, [1, 2])) {
            $this->io->note("Part of day can only be a 1 or 2.");
        }

        $partMethod = "part$part";

        $this->common();
        $this->$partMethod();

        $this->io->success('SUCCESS');

        return Command::SUCCESS;
    }

    private function common(): void
    {
        $file = new SplFileObject($this->inputFilename, "r");
        $elf = new Elf();
        while (!$file->eof()) {
            $calorie = (int) $file->current();

            if ($calorie === 0) {
                $this->elves[] = $elf;
                $elf = new Elf();
            } else {
                $elf->append($calorie);
            }

            $file->next();
        }

        usort($this->elves, function (Elf $elf1, Elf $elf2): int {
            if ($elf1->getCalories() === $elf2->getCalories()) {
                return 0;
            }

            return ($elf1->getCalories() > $elf2->getCalories()) ? -1 : 1;
        });
    }

    private function part1(): void
    {
        $elf = reset($this->elves);
        $this->io->success($elf->getCalories());
    }

    private function part2(): void
    {
        $first3CaloriesSum = 0;
        foreach (array_slice($this->elves, 0, 3) as $elf) {
            $first3CaloriesSum += $elf->getCalories();
        }
        $this->io->success($first3CaloriesSum);
    }
}