<?php declare(strict_types=1);

namespace App;

use App\Domain\Division\Division;
use App\Domain\Game\GameResult;
use App\Domain\PlayOff\PlayOffStep;

class Randomizer
{

    public function randomizeDivisionGamesResults(Division $division): void
    {
        foreach ($division->allGames() as $game) {
            $result = GameResult::createCompleted(random_int(0, 5), random_int(0, 5));
            $game->complete($result);
        }

        // flush()
    }


    public function randomizePlayOffStep(PlayOffStep $playOffStep): void
    {
        foreach ($playOffStep->games() as $game) {
            $score = $this->generateNotEqualScore();
            $game->complete(GameResult::createCompleted($score[0], $score[1]));
        }
    }


    private function generateNotEqualScore(): array
    {
        $score = [random_int(0, 5), random_int(0, 5)];
        if ($score[0] === $score[1]) {
            $score[0] = ++$score[0];
        }
        return $score;
    }
}