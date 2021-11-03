<?php declare(strict_types=1);

namespace App\Domain\PlayOff;

use App\Domain\Division\Division;
use App\Domain\Division\ScoreTableRow;
use App\Domain\Game\Game;
use App\Domain\PlayOff\Exception\MustBeEvenCountPlayersException;

class PlayOffFactory
{
    public static function createFromDivision(Division ...$divisions): PlayOffStep
    {
        $tableRows = [];
        foreach ($divisions as $division) {
            $table = $division->toScoreTable();
            $tableRows = [...$tableRows, ...$table->winners()];
        }
        if (0 !== count($tableRows) % 2) {
            throw new MustBeEvenCountPlayersException();
        }

        usort($tableRows, fn(ScoreTableRow $a, ScoreTableRow $b) => $a->points() > $b->points() ? -1 : 1);

        $teams = array_values(array_map(fn(ScoreTableRow $row) => $row->team(), $tableRows));

        $count = count($teams);

        $games = [];
        for ($i = 0; $i < $count / 2; $i++) {
            $games[] = new Game($teams[$i], $teams[$count - $i - 1]);
        }

        return new PlayOffStep($games);
    }

}