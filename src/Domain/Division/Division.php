<?php declare(strict_types=1);

namespace App\Domain\Division;

use App\Domain\Game\Game;
use App\Domain\Division\ScoreTable;
use App\Domain\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Division
{
    private string $title;
    private Collection $teams;
    private Collection $games;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->games = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }


    public function addTeams(Team  ...$teams): void
    {
        foreach ($teams as $team) {
            $this->addTeam($team);
        }
    }

    public function addTeam(Team $team): void
    {
        if ($this->hasTeam($team)) {
            return;
        }

        $this->teams->add($team);
        $this->scheduleGames($team);
    }

    public function hasTeam(Team $team): bool
    {
        foreach ($this->teams as $divisionTeam) {
            if ($team->isEqual($divisionTeam)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Team[]
     */
    public function teams(): array
    {
        return $this->teams->toArray();
    }

    /**
     * @return Game[]
     */
    public function allGames(): array
    {
        return $this->games->toArray();
    }

    /**
     * @return Game[]
     */
    public function teamGames(Team $team): array
    {
        return array_values(
            array_filter($this->allGames(), fn(Game $game) => $game->hasTeam($team))
        );
    }


    public function isGamesCompleted(): bool
    {
        foreach ($this->allGames() as $game) {
            if (!$game->isCompleted()) {
                return false;
            }
        }

        return true;
    }

    public function findGameForTeams(Team $teamA, Team $teamB): ?Game
    {
        if ($teamA->isEqual($teamB)) {
            return null;
        }

        foreach ($this->allGames() as $game) {
            if ($game->hasTeam($teamA) && $game->hasTeam($teamB)) {
                return $game;
            }
        }
        return null;
    }


    /**
     * @return ScoreTable
     */
    public function toScoreTable(): ScoreTable
    {
        return new ScoreTable($this);
    }


    public function teamScore(Team $team): int
    {
        $score = 0;
        $games = $this->teamGames($team);
        foreach ($games as $game) {
            $score += $game->teamPoints($team);
        }
        return $score;
    }


    public function title(): string
    {
        return $this->title;
    }


    private function scheduleGames(Team $team): void
    {
        foreach ($this->teams as $divisionTeam) {
            if ($team->isEqual($divisionTeam)) {
                continue;
            }

            if ($this->findGameForTeams($team, $divisionTeam)) {
                continue;
            }

            $game = new Game($team, $divisionTeam);
            $this->games->add($game);
        }
    }

}