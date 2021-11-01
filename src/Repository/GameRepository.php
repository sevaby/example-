<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameRepository extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllGames():array
    {
        return $this->em->getRepository(Game::class)->findAll();
    }

    public function getGamesByTeam($team): array
    {
        return array_merge(
            $this->em->getRepository(Game::class)->findBy(['teamA' => $team]),
            $this->em->getRepository(Game::class)->findBy(['teamB' => $team])
        );
    }

}