<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamRepository extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllTeams():array
    {
        return $this->em->getRepository(Team::class)->findAll();
    }


}