<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Threads;
use App\Repository\CategoriesRepository;
use App\Repository\ThreadsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home_redirect(){
        return $this->redirectToRoute('forum',['category'=>'0']);
    }

    /**
     * @Route("/{category}", name="forum")
     */
    public function index($category, ThreadsRepository $repository, Request $request, PaginatorInterface $paginator, CategoriesRepository $categoriesRepository)
    {
        $category_image = 0;
        $categories = $categoriesRepository->findAll();
        $last_id = $categories[0]->getId();
        if(!$category){
            $category = $categoriesRepository->findOneBy(['id'=>$last_id])->getName();
        }

        if($category){
            $category_image = $categoriesRepository->findOneBy(['name' => $category])->getImageFilename();
        }

        $q = $request->query->get('q');

        $category_id = $categoriesRepository->findOneBy(['name' => $category]);
        $queryBuilder = $repository->getWithSearchQueryBuilder($category_id, $q);


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
            'threads' => $pagination,
            'categories' => $categories,
            'selected_category' => $category,
            'selected_category_image' => $category_image,
        ]);
    }

    /**
     * @Route("/forum/{slug}", name="forum_content")
     */
    public function Content(EntityManagerInterface $em, $slug, CategoriesRepository $categoriesRepository)
    {
        $repo = $em->getRepository(Threads::class);
        /**
         * @var Threads $threads
         */
        $threads = $repo->findOneBy(['subject' => $slug]);

        $categories = $categoriesRepository->findAll();
        $category = $categoriesRepository->findOneBy(['id' => $threads->getCategory()]);
        $category_image = $category->getImageFilename();
        return $this->render('base/content.html.twig', [
            'slug' => $slug,
            'threads' => $threads,
            'categories' => $categories,
            'selected_category' => $category->getName(),
            'selected_category_image' => $category_image,
        ]);
    }
}
