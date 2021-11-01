<?php declare(strict_types=1);

namespace App\Domain\PlayOff;

use App\Domain\Game\Game;
use App\Domain\PlayOff\Exception\MustBeEvenCountPlayersException;
use App\Domain\PlayOff\Exception\PlayOffGameNotWinnerException;
use App\Domain\PlayOff\Exception\PlayOffNotCompletedException;
use App\Domain\Team;

class PlayOffStep
{

    private string $title;
    /**
     * @var Team[]
     */
    private array $teams = [];
    /**
     * @var Game[]
     */
    private array $games;


    /**
     * @param Game[] $games
     */
    public function __construct(array $games)
    {
        $this->games = $games;
        foreach ($games as $game) {
            $this->teams[$game->teamA()->id()] = $game->teamA();
            $this->teams[$game->teamB()->id()] = $game->teamB();
        }
        $this->title = sprintf('1/%d', count($this->teams));
    }


    public function nextStep(): self
    {
        if (!$this->isComplited()) {
            throw new PlayOffNotCompletedException();
        }


        /** @var Team[] $winners */
        $winners = [];
        foreach ($this->games as $game) {
            $winner = $game->winner() ?? throw new PlayOffGameNotWinnerException();
            $winners[] = $winner;
        }

        $countWinners = count($winners);

        if (0 !== $countWinners % 2) {
            throw new MustBeEvenCountPlayersException();
        }

        // @todo Sort by business rules
        $games = [];
        for ($i = 0; $i < $countWinners / 2; $i++) {
            $games[] = new Game($winners[$i * 2], $winners[$i * 2 + 1]);
        }

        return new self($games);
    }


    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return Game[]
     */
    public function games(): array
    {
        return $this->games;
    }


    public function isComplited(): bool
    {
        foreach ($this->games as $game) {
            if (false === $game->isCompleted()) {
                return false;
            }
        }
        return true;
    }

    public function isFinal(): bool
    {
        return 1 === count($this->games);
    }

}