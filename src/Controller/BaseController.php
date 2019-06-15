<?php

namespace App\Controller;

use App\Entity\Threads;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="forum")
     */
    public function index(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Threads::class);
        $threads = $repo->findAll();

        return $this->render('base/index.html.twig', [
            'threads' => $threads
        ]);
    }
}
