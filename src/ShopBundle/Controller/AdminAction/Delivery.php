<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-04
 * Time: 14:34
 */

namespace ShopBundle\Controller\AdminAction;
use ShopBundle\Entity\Deliver;
use ShopBundle\Form\Type\AddDeliveryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class Delivery extends Controller
{


    /**
     * @Route("/admin/main", name="deliveryAdmin")
     * @Template("ShopBundle:Settings:Delivery.html.twig")
     */
    public function mainSettingsAdminAction(){
        $Deliver = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findAll();
        return array(
            'delivers' => $Deliver
        );
    }

    /**
     * @Route("/admin/add/delivery", name="addDelivery")
     * @Template("ShopBundle:Settings\Delivery:AddNewDelivery.html.twig")
     */
    public function addNewDeliveryAction(Request $request){
        $Deliver = new Deliver();
        $form = $this->createForm(AddDeliveryType::class,$Deliver);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($Deliver);
            $em->flush();
            return $this->redirectToRoute('deliveryAdmin');
        }
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit/delivery/{idDelivery}", name="editDelivery")
     * @Template("ShopBundle:Settings\Delivery:AddNewDelivery.html.twig")
     */
    public function editDeliveryMethodAction(Request $request,$idDelivery){
        $Delivery = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findById($idDelivery);
        $form = $this->createForm(AddDeliveryType::class,$Delivery[0]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($Delivery[0]);
            $em->flush();
            return $this->redirectToRoute('deliveryAdmin');
        }
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/admin/delete/delivery/{idDelivery}", name="deleteDelivery")
     */
    public function deleteDeliveryAction($idDelivery){
        $Delivery = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findById($idDelivery);
        $em = $this->getDoctrine()->getManager();
        $em->remove($Delivery[0]);
        $em->flush();
        return $this->redirectToRoute('deliveryAdmin');
    }


}