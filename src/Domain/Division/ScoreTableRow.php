<?php declare(strict_types=1);

namespace App\Domain\Division;

use App\Domain\Game\Game;
use App\Domain\Team;

class ScoreTableRow
{
    public Team $team;
    public array $games;
    public int $scores = 0;

    /**
     * @param Game[] $games
     */
    public function __construct(Team $team, array $games)
    {
        $this->team = $team;
        $this->games = $games;

        foreach ($games as $game) {
            $this->scores += $game->teamPoints($team);
        }
    }

    public function team(): Team
    {
        return $this->team;
    }

    public function findGameForTeam(Team $teamB): ?Game
    {
        if ($this->team->isEqual($teamB)) {
            return null;
        }

        foreach ($this->games as $game) {
            if ($game->hasTeam($teamB)) {
                return $game;
            }
        }

        return null;
    }

    public function points(): int
    {
        return $this->scores;
    }
}