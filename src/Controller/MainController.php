<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Team;

use App\GenerateService\GenerateServiceHandler;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private GenerateServiceHandler $generateServiceHandle;

    public function __construct(GenerateServiceHandler $generateServiceHandle)
    {
        $this->generateServiceHandle = $generateServiceHandle;
    }


    #[Route('/', name: 'main')]
    public function matchTable(): Response
    {
        $this->generateServiceHandle->generateGames();

        return $this->render('base.html.twig',[
            'controller_name' => 'MainController'
        ]);
    }


}
