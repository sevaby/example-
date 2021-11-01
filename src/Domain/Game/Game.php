<?php declare(strict_types=1);

namespace App\Domain\Game;

use App\Domain\Game\Exception\GameNotCompletedException;
use App\Domain\Game\Exception\TeamNotPlayInGameException;
use App\Domain\Team;

class Game
{
    private Team $teamA;
    private Team $teamB;
    private GameResult $result;
    private bool $completed;

    public function __construct(Team $teamA, Team $teamB)
    {
        $this->teamA = $teamA;
        $this->teamB = $teamB;
        $this->result = GameResult::createScheduled();
        $this->completed = false;
    }

    public function complete(GameResult $result): void
    {
        $this->result = $result;
        $this->completed = true;
    }

    public function teamPoints(Team $team): int
    {
        if (!$this->completed) {
            throw new GameNotCompletedException();
        }

        if ($this->teamA->isEqual($team)) {
            return $this->result->pointsTeamA();
        }

        if ($this->teamB->isEqual($team)) {
            return $this->result->pointsTeamB();
        }

        throw new TeamNotPlayInGameException();
    }

    public function teamA(): Team
    {
        return $this->teamA;
    }

    public function teamB(): Team
    {
        return $this->teamB;
    }

    public function winner(): ?Team
    {
        if (!$this->completed) {
            throw new GameNotCompletedException();
        }

        if (GameResult::SCORE_WIN === $this->result->pointsTeamA()) {
            return $this->teamA;
        }

        if (GameResult::SCORE_WIN === $this->result->pointsTeamB()) {
            return $this->teamB;
        }

        return null;
    }


    public function hasTeam(Team $team): bool
    {
        return $team->isEqual($this->teamA) || $team->isEqual($this->teamB);
    }


    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function matchScores(Team $team): string
    {
        if ($team->isEqual($this->teamA)) {
            return $this->result->scoresForTeamA();
        }

        if ($team->isEqual($this->teamB)) {
            return $this->result->scoresForTeamB();
        }

        throw new TeamNotPlayInGameException();
    }

}