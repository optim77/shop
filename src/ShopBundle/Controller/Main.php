<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Order;
use ShopBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Main extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template("ShopBundle:Main:Main.html.twig")
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/category/{category}", name="category")
     * @Template("ShopBundle:Category:Type.html.twig")
     */
    public function categoryAction($category){
        $ProductsRepo = $this->getDoctrine()->getRepository("ShopBundle:Products");
        $qb = $ProductsRepo->getCategoryProducts($category);
        return array(
            'products' => $qb
        );
    }

    /**
     * @Route("/staff/{product}", name="product")
     * @Template("ShopBundle:Main:Item.html.twig")
     */
    public function productAction($product){

        $ProductsRepo = $this->getDoctrine()->getRepository('ShopBundle:Products');
        $qb = $ProductsRepo->getProduct($product);


        return array(
            'product' => $qb
        );
    }

    /**
     * @Route("/brand/{brand}", name="brand")
     * @Template("ShopBundle:Category:Brand.html.twig")
     */
    public function brandAction($brand){

        $ProductRepo = $this->getDoctrine()->getRepository('ShopBundle:Products');
        $Brand = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findBySlug($brand);
        $qb = $ProductRepo->getBrandProducts($brand);
        return array(
            'products' =>$qb,
            'brand' => $Brand[0]
        );

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){
        return array();
    }

    /**
     * @Route("/search/", name="search")
     * @Template("ShopBundle:Category:Search.html.twig")
     */
    public function searchAction(Request $request){
        $queryParams = array(
            'search' => $request->query->get('search')
        );
        $Produ = $this->getDoctrine()->getRepository('ShopBundle:Products');
        $qb = $Produ->getQueryBuilder($queryParams);
        dump($qb->getQuery()->getResult());
        return array(
            'products' => $qb->getQuery()->getResult()
        );
    }

    /**
     * @Route("/brands", name="brands")
     * @Template("ShopBundle:Category:Brands.html.twig")
     */
    public function brandsAction(){
        $Brands = $this->getDoctrine()->getRepository("ShopBundle:Brand")->findAll();
        return array(
            'brands' => $Brands
        );
    }



    /**
     * @Route("/contact", name="contact")
     * @Template("ShopBundle:Template:Contact.html.twig")
     */
    public function contactAction(){
        return array();
    }

}
