<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-01
 * Time: 09:09
 */

namespace ShopBundle\Controller\AdminAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends Controller
{

    /**
     * @Route("/admin/orders/{page}", name="adminOrders")
     * @Template("ShopBundle:Admin:Orders.html.twig")
     */
    public function ordersAction(Request $request,$page = 1){
        $queryParams = array(
            'search' => $request->query->get('search'),
            'when' => $request->query->get('when')
        );
        $Orders = $this->getDoctrine()->getRepository('ShopBundle:Order');
        $Products = $this->getDoctrine()->getRepository('ShopBundle:Products');

        //pobieranie wszystkich zamówień
        $qb = $Orders->getQueryBuilder($queryParams);


//        $products = $Products->getOrderProducts($qb);
//        dump($products);
//        foreach ($qb as $key => $value){
//            //dump($value->setProduct($products[$key]));
//        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb,$page,10);
        return array(
            'orders' => $pagination,
            'queryParams' => $queryParams
        );
    }

    /**
     * @Route("/admin/check/user/adress/{idUser}/{orderId}", name="getAdress")
     * @Template("ShopBundle:Admin:AdressUser.html.twig")
     */
    public function getAdressUserAdminAction($idUser,$orderId){
        $Order = $this->getDoctrine()->getRepository('ShopBundle:Order');
        $items = $Order->getOrder($idUser,$orderId);
        $Product = $this->getDoctrine()->getRepository('ShopBundle:Products');
        $qb = $Product->getOrderProducts($items[0]->getProduct());
        return array(
            'user' => $items[0],
            'items' => $qb
        );
    }

    /**
     * @Route("/admin/order/complete/{idOrder}", name="completeOrder")
     */
    public function completeOrderAction($idOrder){
        $Order = $this->getDoctrine()->getRepository('ShopBundle:Order')->findById($idOrder);
        try{
            $Order[0]->setCompleted(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Order[0]);
            $em->flush();
        }catch (Exception $exception){
            echo $exception->getMessage();
        }
        return $this->redirectToRoute('adminOrders');
    }

}