<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\StoreTeam;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreRepository extends AbstractController

{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(Team $team, $points, $countGames)
    {
        $storeTeam = new StoreTeam($team, $points, $countGames);
        $this->em->persist($storeTeam);
    }

    public function allStoresTeam(): array
    {
        return $this->em->getRepository(StoreTeam::class)->findBy([], ['store' => 'DESC']);
    }

    public function getStoryTeamByTeam($team)
    {
       return $this->em->getRepository(StoreTeam::class)->findBy(['team' => $team], ['store' => 'DESC']);
    }

}