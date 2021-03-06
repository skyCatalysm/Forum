<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Threads;
use App\Form\CategoryFormType;
use App\Form\ReplyFormType;
use App\Form\ThreadsFormType;
use App\Repository\CategoriesRepository;
use App\Repository\ThreadsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{


    /**
     * @Route("/", name="forum")
     */
    public function index(ThreadsRepository $repository, Request $request, PaginatorInterface $paginator, CategoriesRepository $categoriesRepository)
    {
        $categories = $categoriesRepository->findAll();

        $first_id = $categories[0]->getId();

        $category = $request->query->get('category');

        if(!$category){
            $category = $categoriesRepository->findOneBy(['id'=>$first_id])->getName();
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
     * @Route("/forum/{category}/{slug}", name="forum_content")
     */
    public function Content(EntityManagerInterface $em, $slug, CategoriesRepository $categoriesRepository, Request $request)
    {
        $repo = $em->getRepository(Threads::class);
        /**
         * @var Threads $threads
         */
        $threads = $repo->findOneBy(['id' => $slug]);



        $categories = $categoriesRepository->findAll();
        $category = $categoriesRepository->findOneBy(['id' => $threads->getCategory()]);

        $category_image = $category->getImageFilename();



        $replyForm = null;
        if ($this->isGranted('ROLE_USER')){
            $form =$this->createForm(ReplyFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $user = $this->getUser();


                $replyModel = $form->getData();

                $replyModel->setAuthor($user);
                $replyModel->setThread($threads);
                $em->persist($replyModel);
                $em->flush();

                $this->addFlash('success', 'New thread successfully created!');

                return $this->redirectToRoute('forum_content', ['category'=> $category->getId(), 'slug' => $slug]);
            }
            $replyForm = $form->createView();
        }


        return $this->render('base/content.html.twig', [
            'replyForm' => $replyForm,
            'slug' => $slug,
            'threads' => $threads,
            'categories' => $categories,
            'selected_category' => $category->getName(),
            'selected_category_image' => $category_image,
        ]);
    }


    /**
     * @Route("/forum/create", name="forum_create" )
     * @IsGranted("ROLE_USER")
     */
    public function CreateThread(Request $request, EntityManagerInterface $em, CategoriesRepository $categoriesRepository,UserRepository $userRepository)
    {
        $categories = $categoriesRepository->findAll();

        $first_id = $categories[0]->getId();

        $category = $request->query->get('category');

        if(!$category){
            $category = $categoriesRepository->findOneBy(['id'=>$first_id])->getName();
        }

        if($category){
            $category_image = $categoriesRepository->findOneBy(['name' => $category])->getImageFilename();
        }

        $form =$this->createForm(ThreadsFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $threadCategory = $categoriesRepository->findOneBy(['name'=>$category]);


            $threadModel = $form->getData();
            $thread = new Threads();
            $thread->setAuthor($user)
                ->setSubject($threadModel->getSubject())
                ->setContent($threadModel->getContent())
                ->setCategory($threadCategory);

            $em->persist($thread);
            $em->flush();

            $this->addFlash('success', 'New thread successfully created!');

            return $this->redirectToRoute('forum', ['category'=> $category]);
        }

        return $this->render('base/create.html.twig', [
            'categories' => $categories,
            'selected_category' => $category,
            'selected_category_image' => $category_image,
            'threadForm' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CategoriesRepository $categoriesRepository
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/category/create", name="category_create")
     * @IsGranted("ROLE_USER")
     */
    public function CreateCategory(Request $request, EntityManagerInterface $em, CategoriesRepository $categoriesRepository,UserRepository $userRepository){
        $categories = $categoriesRepository->findAll();

        $first_id = $categories[0]->getId();

        $category = $request->query->get('category');

        if(!$category){
            $category = $categoriesRepository->findOneBy(['id'=>$first_id])->getName();
        }

        if($category){
            $category_image = $categoriesRepository->findOneBy(['name' => $category])->getImageFilename();
        }
        $form =$this->createForm(CategoryFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $categoryModel = $form->getData();
            $categoryModel->setTotalThreads(0);
            $em->persist($categoryModel);
            $em->flush();

            $this->addFlash('success', 'New thread successfully created!');

            return $this->redirectToRoute('forum', ['category'=> $category]);
        }

        return $this->render('category/create.html.twig', [
            'categories' => $categories,
            'selected_category' => $category,
            'selected_category_image' => $category_image,
            'categoryForm' => $form->createView()
        ]);
    }
}
