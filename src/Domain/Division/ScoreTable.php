<?php declare(strict_types=1);

namespace App\Domain\Division;

use App\Domain\Division\Division;
use App\Domain\Division\ScoreTableRow;
use App\Domain\Team;

class ScoreTable
{
    private string $title;
    /**
     * @var ScoreTableRow[]
     */
    private array $rows = [];

    public function __construct(Division $division)
    {
        $this->title = $division->title();
        foreach ($division->teams() as $team) {
            $this->rows[] = new ScoreTableRow($team, $division->teamGames($team));
        }

        usort($this->rows, fn(ScoreTableRow $a, ScoreTableRow $b) => $a->points() > $b->points() ? -1 : 1);
    }


    public function title(): string
    {
        return $this->title;
    }


    public function rows(): array
    {
        return $this->rows;
    }


    /**
     * @return ScoreTableRow[]
     */
    public function winners(): array
    {
        $countWinners = (int)floor(count($this->rows) / 2);
        return array_slice($this->rows, 0, $countWinners);
    }
}