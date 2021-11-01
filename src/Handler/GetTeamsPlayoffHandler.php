<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity\StoreTeam;
use App\Entity\Team;
use App\Repository\DivisionRepository;
use App\Repository\GameRepository;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;

class GetTeamsPlayoffHandler
{
    private DivisionRepository $divisionRepository;
    private GameRepository $gameRepository;
    public StoreRepository $storeRepository;
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em,
        DivisionRepository $divisionRepository,
        GameRepository $gameRepository,
        StoreRepository $storeRepository
    ) {
        $this->em = $em;
        $this->divisionRepository = $divisionRepository;
        $this->gameRepository = $gameRepository;
        $this->storeRepository = $storeRepository;
    }


    public function getTeamsPlayoff(): array
    {
        $this->createStoryTable();
        $divisions = $this->divisionRepository->getAllDivisions();
        foreach ($divisions as $division) {
            $teams = $division->teams();
            foreach ($teams as $team) {
                $storeTeam[$division->title()][] = $this->storeRepository->getStoryTeamByTeam($team);
            }
            $teamsPlayoff = $this->maxResultTeam($storeTeam[$division->title()]);
        }
//        dump($teamsPlayoff);
        return $teamsPlayoff;
    }

    public function maxResultTeam(array $storeTeams): array
    {
        $divisionTeamsWin = [];
        $maxStore = 0;
        for ($i = 0; $i < 4; $i++){
            foreach ($storeTeams as $storeTeam) {
                $maxResult = $storeTeam[0]->store();
                if ($maxResult > $maxStore) {
                    $maxStore = $maxResult;
                    $divisionTeamsWin[$i] = $storeTeam;
                }
            }

        }

return [];
    }

    public function createStoryTable(): void
    {
        $divisions = $this->divisionRepository->getAllDivisions();
        foreach ($divisions as $division) {
            $teams = $division->teams();
            foreach ($teams as $team) {
                $teamGames = $this->gameRepository->getGamesByTeam($team);
                $this->createStoryTeam($teamGames, $team);
                $this->em->flush();
            }
        }
    }

    public function createStoryTeam(array $teamGames, Team $team)
    {
        $points = 0;
        $countGames = 0;
        foreach ($teamGames as $teamGame) {
            $points += $this->pointStory($teamGame, $team);
            $countGames++;
        }
        $this->storeRepository->insert($team, $points, $countGames);
        $this->em->flush();
    }

    public function pointStory($teamGame, $team): int
    {
        if ($teamGame->getWinner() === $team) {
            return 2;
        } else {
            if (is_null($teamGame->getWinner())) {
                return 0;
            }
        }
        return 1;
    }

}