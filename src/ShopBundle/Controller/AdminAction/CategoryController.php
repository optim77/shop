<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-29
 * Time: 23:08
 */

namespace ShopBundle\Controller\AdminAction;
use ShopBundle\Entity\Brand;
use ShopBundle\Entity\Category;
use ShopBundle\Entity\Products;
use ShopBundle\Form\Type\AddBrandType;
use ShopBundle\Form\Type\AddCategory;
use ShopBundle\Form\Type\AddProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{

    /**
     * @Route("/admin/add/product", name="addProduct")
     * @Template("ShopBundle:Admin:AddProduct.html.twig")
     */
    public function addCategoryAdminAction(Request $request){
        $Category = new Category();
        $categories = $this->getDoctrine()->getRepository('ShopBundle:Category')->findAll();
        $form = $this->createForm(AddCategory::class,$Category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slug = self::slugify($_POST['name'],'new');
            $Category->setSlug($slug);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Category);
            $em->flush();
            return $this->redirectToRoute('admin');
        }


        return array(
            'form' => $form->createView(),
            'categories' => $categories
        );

    }

    /**
     * @Route("/admin/edit/category/{page}", name="editCategory", requirements={"page"="\d+"})
     * @Template("ShopBundle:Admin:Category.html.twig")
     */
    public function EditCategoryAdminAction(Request $request, $page = 1){
        $queryParams = array(
            'search' => $request->query->get('search')
        );
        $Categories = $this->getDoctrine()->getRepository('ShopBundle:Category');
        $qb = $Categories->getQueryBuilder($queryParams);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb,$page,5);
        return array(
            'categories' => $pagination,
            'queryParams' => $queryParams

        );
    }




    /**
     * @Route("/admin/edit/category/item/{slug}", name="editSuchCategory")
     * @Template("ShopBundle:Admin:Category.html.twig")
     */
    public function editSuchCategoryAdminAction(Request $request, $slug = null)
    {
        $Category = $this->getDoctrine()->getRepository('ShopBundle:Category')->findBySlug($slug);
        $form = $this->createForm(AddCategory::class, $Category[0]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = self::slugify($_POST['name'],'edit');
            $Category[0]->setSlug($slug);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Category[0]);
            $em->flush();
            return $this->redirectToRoute('editCategory');
        }
        return array(
            'form' => $form->createView()
        );
    }


    public function slugify($text,$flag)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        $BrandName = $this->getDoctrine()->getRepository('ShopBundle:Category')->findByName($_POST['name']);

        if ($flag == 'edit'){
            if( $text != $BrandName[0]->getSlug() ){
                $random = rand(1,1000);
                $text = $BrandName[0]->getSlug();
            }
        }
        elseif ($flag == 'new'){
            if( $text == $BrandName[0]->getSlug() ){
                $random = rand(1,1000);
                $text = $text.'-'.$random;
            }
        }

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}