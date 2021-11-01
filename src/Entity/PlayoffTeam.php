<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="playoff_team")
 */
class PlayoffTeam
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
     * @ORM\Column(name="place_in_division", nullable=false)
     */
    private int $placeDivision;

    /**
     * @ORM\Column(name="active", nullable=false)
     */
    private bool $active = true;

    /**
     * @ORM\Column(name="place_playoff", nullable=true)
     */
    private ?int $placePlayoff = null;

    public function __construct(Team $team, int $placeDivision)
    {
        $this->team = $team;
        $this->placeDivision = $placeDivision;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getPlaceDivision(): int
    {
        return $this->placeDivision;
    }



}