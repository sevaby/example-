<?php declare(strict_types=1);

namespace App\GenerateService;

use App\Entity\Division;
use App\Entity\Game;
use App\Repository\DivisionRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;

class GenerateServiceHandler
{
    const DIVISIONS = ['Division A', 'Division B'];

    private TeamRepository $teamRepository;
    private DivisionRepository $divisionRepository;
    private EntityManagerInterface $em;

    public function __construct(
        TeamRepository $teamRepository,
        EntityManagerInterface $em,
        DivisionRepository $divisionRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->em = $em;
        $this->divisionRepository = $divisionRepository;
    }

    public function generateGames()
    {
        $divisions = $this->divisionRepository->getAllDivisions();

        foreach ($divisions as $division) {
            $teams = $division->teams();
            for ($i = 0; $i < (count($teams) - 1); $i++) {
                for ($k = $i; $k < (count($teams) - 1); $k++) {
                    $game = new Game($teams[$i], $teams[$k + 1]);
                    $game->gameCompeted(rand(0, 5), rand(0, 5));
                    $this->em->persist($game);
                }
            }
            $this->em->flush();
        }
    }
}
