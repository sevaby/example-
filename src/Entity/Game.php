<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="game")
 */
class Game
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="team_a", referencedColumnName="id", nullable=false)
     */
    private Team $teamA;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="team_b", referencedColumnName="id", nullable=false)
     */
    private Team $teamB;

    /**
     * @ORM\Column(name="completed", type="boolean", nullable=false)
     */
    private bool $completed = false;

    /**
     * @ORM\Column(name="goals_team_a", type="smallint", nullable=true)
     */
    private ?int $goalsTeamA = null;

    /**
     * @ORM\Column(name="goals_team_b", type="smallint", nullable=true)
     */
    private ?int $goalsTeamB = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="team_winner", referencedColumnName="id", nullable=true)
     */
    private ?Team $winner = null;

    public function __construct($teamA, $teamB)
    {
        $this->teamA = $teamA;
        $this->teamB = $teamB;
    }

    public function teamA(): Team
    {
        return $this->teamA;
    }

    public function teamB(): Team
    {
        return $this->teamB;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getGoalsTeamA(): ?int
    {
        return $this->goalsTeamA;
    }

    public function getGoalsTeamB(): ?int
    {
        return $this->goalsTeamA;
    }

    public function gameCompeted(int $goalsTeamA, int $goalsTeamB):void
    {
        $this->completed = true;
        $this->goalsTeamA = $goalsTeamA;
        $this->goalsTeamB = $goalsTeamB;
        $this->winner = $this->winner();

    }

    public function getWinner(): ?Team
    {
        return $this->winner;
    }

    private function winner(): ?Team
    {
        $result = $this->goalsTeamA - $this->goalsTeamB;

        if ($result > 0)
        {
            return $this->teamA;
        }
        if ($result < 0)
        {
            return $this->teamB;
        }
        return null;
    }
}