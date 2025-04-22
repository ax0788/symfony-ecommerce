<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {

$categories = $categoryRepository->findAll(); 
        return $this->render('category/index.html.twig', [
            'categories'=> $categories
        ]);
    }


    #[Route('/admin/category/new', name: 'app_category_new')]
    public function addCategory(EntityManagerInterface $entity_manager, Request $request): Response

    {
$category = new Category();
$form = $this->createForm(CategoryFormType::class, $category);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) { 
    $entity_manager->persist($category);
    $entity_manager->flush();

$this->addFlash('success', 'Category added sucessfully');
           return $this->redirectToRoute('app_category');

}

        return $this->render('category/new.html.twig', ['form'=>$form->createView() ]);
    }

    #[Route('/admin/category/{id}/update', name: 'app_category_update')]
    public function update(Category $category, EntityManagerInterface $entity_manager, Request $request):Response {
 $form = $this->createForm(CategoryFormType::class, $category);

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) { 
    $entity_manager->flush();
$this->addFlash('success', 'Category updated sucessfully');

           return $this->redirectToRoute('app_category');
}
        return $this->render('category/update.html.twig', ['form'=>$form->createView() ]);


}



    #[Route('/admin/category/{id}/delete', name: 'app_category_delete')]
    public function delete(Category $category, EntityManagerInterface $entity_manager):Response {

    $entity_manager->remove($category);
$entity_manager->flush();
$this->addFlash('danger', 'Category deleted sucessfully');


     return $this->redirectToRoute('app_category');

}

}