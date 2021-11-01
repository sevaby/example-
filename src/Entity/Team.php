<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="team")
 */
class Team
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column (name="name", type="string", nullable=false)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Division", inversedBy="teams")
     * @ORM\JoinColumn(name="division_id", referencedColumnName="id", nullable=true)
     */
    private ?Division $division;

    public function __construct(string $name, ?Division $division)
    {
        $this->name = $name;
        $this->division = $division;
    }

    public function addToDivision(Division $division): void
    {
        $this->division = $division;
    }

    public function name(): string
    {
        return $this->name;
    }
}