<?php declare(strict_types=1);

namespace App\Domain\Game;

class GameResult
{

    public const SCORE_WIN = 2;
    public const SCORE_DRAW = 1;
    public const SCORE_FAIL = 0;

    private ?int $goalsTeamA;
    private ?int $goalsTeamB;

    private function __construct(?int $goalsTeamA, ?int $goalsTeamB)
    {
        $this->goalsTeamA = $goalsTeamA;
        $this->goalsTeamB = $goalsTeamB;
    }

    public static function createScheduled(): self
    {
        return new self(null, null);
    }

    public static function createCompleted(int $goalsTeamA, int $goalsTeamB): self
    {
        return new self($goalsTeamA, $goalsTeamB);
    }

    public function pointsTeamA(): int
    {
        if ($this->goalsTeamA === $this->goalsTeamB) {
            return self::SCORE_DRAW;
        }

        if ($this->goalsTeamA > $this->goalsTeamB) {
            return self::SCORE_WIN;
        }

        return self::SCORE_FAIL;
    }

    public function pointsTeamB(): int
    {
        if ($this->goalsTeamA === $this->goalsTeamB) {
            return self::SCORE_DRAW;
        }
        if ($this->goalsTeamA < $this->goalsTeamB) {
            return self::SCORE_WIN;
        }

        return self::SCORE_FAIL;
    }

    public function scoresForTeamA(): string
    {
        if (null === $this->goalsTeamA) {
            return 'Waiting...';
        }

        return sprintf('%d : %d', $this->goalsTeamA, $this->goalsTeamB);
    }

    public function scoresForTeamB(): string
    {
        if (null === $this->goalsTeamA) {
            return 'Waiting...';
        }

        return sprintf('%d : %d', $this->goalsTeamB, $this->goalsTeamA);
    }

}