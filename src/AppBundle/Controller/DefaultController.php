<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    const PRODUCT_PER_PAGE = 6;

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $this->getDoctrine()->getRepository(Product::class);
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT p FROM AppBundle:Product p";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            self::PRODUCT_PER_PAGE
        );

        return $this->render('index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/{category}", name="category")
     * @param $category
     * @return Response
     */
    public function categoryPageAction($category): Response
    {
        $currentProducts = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findProductsByCategoryName($category);
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('category.html.twig', [
            'products' => $currentProducts,
            'categories' => $categories
        ]);
    }
}
