<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-29
 * Time: 23:10
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

class ProductController extends Controller
{

    /**
     * @Route("/admin/add/staff", name="addStaff")
     * @Template("ShopBundle:Admin:AddStuff.html.twig")
     */
    public function addProductAdminAction(Request $request){

        $Brands = $this->getDoctrine()->getRepository('ShopBundle:Brand');
        $Categories = $this->getDoctrine()->getRepository('ShopBundle:Category');
        $brands = $Brands->getArray();
        $categories = $Categories->getArray();

        $Product = new Products();
        $form = $this->createForm(AddProductType::class,$Product,array('allow_extra_fields' => true));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            dump($_POST);
            $slug = self::slugify($_POST['name'],'new');
            $Product->setSlug($slug);
            $Product->setCreateDate(new \DateTime());
            $Category = $this->getDoctrine()->getRepository('ShopBundle:Category')->findById($_POST['category']);
            $Brand = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findById($_POST['brand']);
            $Product->setCategory($Category[0]);
            $Product->setBrand($Brand[0]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Product);
            $em->flush();
            return $this->redirectToRoute('admin');

        }
        return array(
            'form' => $form->createView(),
            'categories' => $categories,
            'brands' => $brands
        );
    }

    /**
     * @Route("/admin/edit/staff/{page}", name="editStuff", requirements={"page"="\d+"})
     * @Template("ShopBundle:Admin:Product.html.twig")
     */
    public function editProductAdminAction(Request $request, $page = 1){
        $queryParams = array(
            'search' => $request->query->get('search'),
            'categoryId' => $request->query->get('categoryId'),
            'brandId' => $request->query->get('brandId')
        );
        $Produ = $this->getDoctrine()->getRepository('ShopBundle:Products');
        $Category = $this->getDoctrine()->getRepository('ShopBundle:Category')->getArray();
        $Brands = $this->getDoctrine()->getRepository('ShopBundle:Brand')->getArray();
        $qb = $Produ->getQueryBuilder($queryParams);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb,$page,10);
        return array(
            'products' => $pagination,
            'queryParams' => $queryParams,
            'categories' => $Category,
            'brands' => $Brands
        );

    }

    /**
     * @Route("/admin/edit/product/item/{slug}", name="editSuchProduct")
     * @Template("ShopBundle:Admin:Product.html.twig")
     */
    public function editSuchProductAdminAction(Request $request, $slug = null){

        $Product = $this->getDoctrine()->getRepository('ShopBundle:Products')->editProduct($slug);
        $Brands = $this->getDoctrine()->getRepository('ShopBundle:Brand')->getArray();
        $Categories = $this->getDoctrine()->getRepository('ShopBundle:Category')->getArray();

        $form = $this->createForm(AddProductType::class,$Product[0],array('allow_extra_fields' => true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $slug = self::slugify($_POST['name'],'edit');
            $Category = $this->getDoctrine()->getRepository('ShopBundle:Category')->findById($_POST['category']);
            $Brand = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findById($_POST['brand']);
            dump($Brand[0]);
            $Product[0]->setBrand($Brand[0]);
            $Product[0]->setCategory($Category[0]);
            $Product[0]->setSlug($slug);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Product[0]);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return array(
            'form' => $form->createView(),
            'categories' => $Categories,
            'brands' => $Brands,
            'defaultCategory' => $Product[0]->getCategory(),
            'defaultBrand' => $Product[0]->getBrand()
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

        $BrandName = $this->getDoctrine()->getRepository('ShopBundle:Products')->findByName($_POST['name']);
        dump($BrandName[0]->getSlug());
        dump($text);


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