<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="store")
 */
class StoreTeam
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", nullable=false)
     */
    private Team $team;

    /**
     * @ORM\Column(name="store", type="smallint", nullable=false)
     */
    private int $store;

    /**
     * @ORM\Column(name="count_games", type="smallint", nullable=false)
     */
    private int $countGames = 0;


    public function __construct(Team $team, int $store, int $countGames)
    {
        $this->team = $team;
        $this->store = $store;
        $this->countGames = $countGames;
    }

    public function team(): Team
    {
        return $this->team;
    }

    public function store(): ?int
    {
        return $this->store;
    }

    public function countGames(): ?int
    {
        return $this->countGames;
    }
}