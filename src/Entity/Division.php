<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="division")
 */
class Division
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="division")
     */
    private Collection $teams;

    private Collection $games;
    /**
     * @ORM\Column(name="title", type="string")
     */
    private string $title;

    public function __construct(string $title)
    {
        $this->id = 0;
        $this->title = $title;
        $this->teams = new ArrayCollection();
    }

    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return Team[]
     */
    public function teams(): array
    {
        return $this->teams->toArray();
    }

    public function title(): string
    {
        return $this->title;
    }
}