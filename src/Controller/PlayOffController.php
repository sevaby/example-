<?php declare(strict_types=1);

namespace App\Controller;

use App\Handler\GetTeamsPlayoffHandler;
use App\Repository\DivisionRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayOffController extends AbstractController
{
    private GetTeamsPlayoffHandler $handler;

    /**
     * @param DivisionRepository $divisionRepository
     */
    public function __construct(GetTeamsPlayoffHandler $handler)
    {
        $this->handler = $handler;
    }


    #[Route('/playoff', name: 'playoff')]
    public function getListTeamsPlayoff()
    {
        $this->handler->getTeamsPlayoff();

        return $this->render('base.html.twig');
    }


}