<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-29
 * Time: 23:05
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

class BrandsController extends Controller
{

    /**
     * @Route("/admin/add/brand", name="addBrand")
     * @Template("ShopBundle:Admin:AddBrand.html.twig")
     */
    public function addBrandAdminAction(Request $request){
        $Brand = new Brand();
        $form = $this->createForm(AddBrandType::class,$Brand);
        $Brands = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $slug = self::slugify($_POST['name'],'new');
            $Brand->setSlug($slug);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Brand);
            $em->flush();
            return $this->redirectToRoute('admin');

        }

        return array(
            'form' => $form->createView(),
            'brands' => $Brands
        );
    }

    /**
     * @Route("/admin/edit/brand/{page}", name="editBrand", requirements={"page"="\d+"})
     * @Template("ShopBundle:Admin:Brand.html.twig")
     */
    public function editBrandAdminAction(Request $request,$page = 1){

        $queryParams = array(
            'search' => $request->query->get('search')
        );

        $R = $this->getDoctrine()->getRepository('ShopBundle:Brand');
        $qb = $R->getQueryBuilder($queryParams);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb, /* query NOT result */
            $page,
            5/*limit per page*/
        );
        return array(
            'brands' => $pagination,
            'queryParams' => $queryParams
        );

    }

    /**
     * @Route("/admin/edit/brand/item/{slug}", name="editSuchBrand")
     * @Template("ShopBundle:Admin:Brand.html.twig")
     */
    public function editSuchBrandAdminAction(Request $request, $slug = null){
        $Brand = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findBySlug($slug);
        $form = $this->createForm(AddBrandType::class,$Brand[0]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slug = self::slugify($_POST['name'],'edit');
            $Brand[0]->setName($_POST['name']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Brand[0]);
            $em->flush();
            return $this->redirectToRoute('editBrand');
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

        $BrandName = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findByName($_POST['name']);


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