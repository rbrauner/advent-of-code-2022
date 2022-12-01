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

// Part 1
// $elf = array_reduce($elves, function (?Elf $carry, Elf $item): Elf {
//     return isset($carry) && $carry->getCalories() > $item->getCalories() ? $carry : $item;
// });

// Part 2
usort($elves, function (Elf $elf1, Elf $elf2): int {
    if ($elf1->getCalories() === $elf2->getCalories()) {
        return 0;
    }

    return ($elf1->getCalories() > $elf2->getCalories()) ? -1 : 1;
});

$first3CaloriesSum = 0;
foreach (array_slice($elves, 0, 3) as $elf) {
    $first3CaloriesSum += $elf->getCalories();
}

print("Calories carrying by 3 top elves is: " . $first3CaloriesSum . "\n");
