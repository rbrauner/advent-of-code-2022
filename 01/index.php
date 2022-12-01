<?php

class Elf
{
    public function __construct(
        private int $calories = 0
    )
    {
    }

    public function append(int $calorie): void
    {
        $this->calories += $calorie;
    }

    public function getCalories(): int
    {
        return $this->calories;
    }
}

$elves = [];

$file = new SplFileObject("input.txt", "r");
$elf = new Elf();
while (!$file->eof()) {
    $calorie = (int) $file->current();

    if ($calorie === 0) {
        $elves[] = $elf;
        $elf = new Elf();
    } else {
        $elf->append($calorie);
    }

    $file->next();
}

$elf = array_reduce($elves, function (?Elf $carry, Elf $item): Elf {
    return isset($carry) && $carry->getCalories() > $item->getCalories() ? $carry : $item;
});

print("Most calories carrying by elf is: " . $elf->getCalories() . "\n");
