<?php declare(strict_types=1);

namespace App\Controller;

use App\Domain\Division\Division;
use App\Domain\PlayOff\PlayOffFactory;
use App\Domain\Team;
use App\Randomizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    private Randomizer $randomizer;

    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    #[Route(path: '/', name: 'main', methods: ['GET'])]
    public function table(): Response
    {
        $divisions = [
            $this->generateDivision('Group A', 'ES', 'EE', 'BY', 'UA'),
            $this->generateDivision('Group A', 'RU', 'LT', 'DE', 'IT'),
        ];

        foreach ($divisions as $division) {
            $this->randomizer->randomizeDivisionGamesResults($division);
        }

        $tableScores = array_map(fn(Division $division) => $division->toScoreTable(), $divisions);

        $playOff = PlayOffFactory::createFromDivision(...$divisions);
        $this->randomizer->randomizePlayOffStep($playOff);
        $playOffSteps = [$playOff];

        while (!$playOff->isFinal()) {
            $playOff = $playOff->nextStep();
            $this->randomizer->randomizePlayOffStep($playOff);
            $playOffSteps[] = $playOff;
        }

        return $this->render('main.html.twig', [
            'tableScores' => $tableScores,
            'playOffSteps' => $playOffSteps
        ]);
    }

    private function generateDivision(string $title, string ...$teams): Division
    {
        $division = new Division($title);
        $division->addTeams(...array_map(fn(string $teamName) => new Team($teamName), $teams));

        return $division;
    }
}