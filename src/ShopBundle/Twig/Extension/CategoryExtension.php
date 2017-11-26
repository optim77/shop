<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-21
 * Time: 15:49
 */

namespace ShopBundle\Twig\Extension;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Twig_Environment;


class CategoryExtension extends \Twig_Extension
{

    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;

    /**
     * CategoryExtension constructor.
     * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
     */
    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @var \Twig_Environment
     */
    private $enviroment;

    public function initRuntime(Twig_Environment $environment)
    {
        $this->enviroment = $environment;
    }



    public function getName()
    {
        return 'shop_category_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('category',array($this,'category'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('mainPageProducts',array($this,'getRecentProducts'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction("topLabel",array($this,'getTopLabel'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction("propose",array($this,'getPropose'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction("currency",array($this,'currency'),array('is_safe' => array('html')))
        );

    }

    public function category(){

        $categoryRepo = $this->doctrine->getRepository('ShopBundle:Category')->findAll();

        return $this->enviroment->render('ShopBundle:Template:CategoryList.html.twig',array(
            'categories' => $categoryRepo
        ));
    }


    public function getRecentProducts(){
        $CategoryRepo = $this->doctrine->getRepository('ShopBundle:Products');
        $products = $CategoryRepo->MainPageProducts(20);
        dump($products);
        return $this->enviroment->render("ShopBundle:Template:MainPageProducts.html.twig",array(
            'products' => $products
        ));
    }

    public function getTopLabel(){
        return $this->enviroment->render("ShopBundle:Template:TopLabel.html.twig");
    }


    public function getPropose(){
        $Products = $this->doctrine->getRepository('ShopBundle:Products');
        $qb = $Products->MainPageProducts(5);
        dump($qb);
        return $this->enviroment->render("ShopBundle:Template:Propose.html.twig",array(
            'proposes' => $qb
        ));
    }

    public function currency($currency){
        switch ($currency){
            case 'PLN':
                return 'PLN';
                break;
            case 'EU':
                return '€';
                break;
            case 'USD':
                return '$';
                break;
            default:
                return '$';
        }
    }

}