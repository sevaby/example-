<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Division;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DivisionRepository extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function getAllDivisions():array
    {
        return $this->em->getRepository(Division::class)->findAll();
    }

}