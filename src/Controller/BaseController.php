<?php

namespace App\Controller;

use App\Entity\Threads;
use App\Repository\ThreadsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="forum")
     */
    public function index(ThreadsRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');

        $queryBuilder = $repository->getWithSearchQueryBuilder($q);


        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        $pagination->setCustomParameters([
            'position' => 'centered',
            'rounded' => true,
        ]);

        return $this->render('base/index.html.twig', [
            'threads' => $pagination
        ]);
    }

    /**
     * @Route("/forum/{slug}", name="forum_content")
     */
    public function Content(EntityManagerInterface $em, $slug)
    {
        $repo = $em->getRepository(Threads::class);
        $threads = $repo->findOneBy(['subject' => $slug]);
        return $this->render('base/content.html.twig', [
            'slug' => $slug,
            'threads' => $threads
        ]);
    }
}
