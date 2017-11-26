<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-11
 * Time: 10:43
 */

namespace ShopBundle\Controller\Ajax;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UpdateDeliveryController extends Controller
{

    /**
     * @Route("/ajax", name="AJAXUPDATEDELIVERY")
     */
    public function updateDeliveryAction(){

        $id = $_POST['val'];
        $Delivery = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findById($id);
        $Cost = $Delivery[0]->getCost();
        $response = array('code' => 100, "success" => true, "costDelivery" => $Cost);

        return new JsonResponse($response);
    }

}