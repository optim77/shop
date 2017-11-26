<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-12
 * Time: 11:18
 */

namespace ShopBundle\Controller\AdminAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Order;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Basket extends Controller
{
    /**
     * @Route("addToBasket/{item}", name="addToBasket")
     */
    public function addToBasketAction(Request $request,$item){
        try{
            $this->getUser();
        }catch (\Exception $exception){
            $exception->getMessage('You have to be sing in');
        }
        $user = $this->getUser();
        $Product = $this->getDoctrine()->getRepository('ShopBundle:Products')->findById($item);
        $Delivery = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findById(3);
        $id = $Product[0]->getId();

        $currentBasket = $user->getBasket();
        if($currentBasket != null){
            $allItems = array_merge($currentBasket, array($id));
        }else{
            $allItems = array($id);
        }


        $user->setBasket($allItems);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $Product[0]->setAmounts($Product[0]->getAmounts() - 1);
        $em->persist($Product[0]);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }

    public function setAdmin(){
        $User = $this->getUser();
        $User->setRoles(array('ROLE_ADMIN'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($User);
        $em->flush();
    }

    /**
     * @Route("/basket", name="basket")
     * @Template("ShopBundle:Basket:Basket.html.twig")
     */
    public function basketAction(){

        $User = $this->getUser();
        dump($User);
        $Items = $User->getBasket();
        dump($User);
        $Products = $this->getDoctrine()->getRepository('ShopBundle:Products');
        if ($Items != null){
            $qb = $Products->getBasketProducts($Items);
            $Delivery = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findAll();
        }
        return array(
            'basket' => isset($qb) ? $qb : null,
            'deliveries' => isset($Delivery) ? $Delivery : null
        );
    }

    /**
     * @Route("/basket/delete/{item}", name="deleteFromBasket")
     */
    public function deleteFromBasketAction(Request $request, $item){
        $User = $this->getUser();
        $CurrentBasket = $User->getBasket();

        foreach ($CurrentBasket as $key => $value){
            if ($value == $item){
                unset($CurrentBasket[$key]);
                $User->setBasket($CurrentBasket);
                $em = $this->getDoctrine()->getManager();
                $em->persist($User);
                $em->flush();
                break;
            }

            $Item = $this->getDoctrine()->getRepository('ShopBundle:Products')->findById($item);
            $CurrentAmount = $Item[0]->getAmounts();
            $Item[0]->setAmounts($CurrentAmount + 1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Item[0]);
            $em->flush();
        }
        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/basket/finalize", name="basketFinalize")
     */
    public function closingShoppingAction(Request $request){
        $User = $this->getUser();


        if ($User->getCity() == null || $User->getNumber() == null || $User->getPhone() == null  || $User->getZipCode() == null || $User->getCity() == null || $User->getCountry() == null || $User->getSurname() == null ){
            return $this->redirectToRoute('profile');
        }




        //$id = substr(md5(uniqid(NULL,TRUE)),2,10);
        //$id = uniqid(false,true);
        $id = substr(hexdec(uniqid(false, true)),5,10);
        $deliveryMethod = $_POST['deliveryType'];
        $Delivery = $this->getDoctrine()->getRepository('ShopBundle:Deliver')->findById($deliveryMethod);
        $Basket = $User->getBasket();
        $Order = new Order();
        $Order->setOrderId($id);
        $Order->setPayed(false);
        $Order->setBill(false);
        $Order->setPurchaseDate(new \DateTime());
        $Order->setCompleted(false);
        $Order->setProduct($Basket);
        $Order->setUser($User);
        $Order->setDelivery($Delivery[0]);
        $currentBought = $User->getBought();

        $msgBody = $this->renderView('ShopBundle:Email:Order.html.twig',array(
            'items' => $Basket,
            'delivery' => $Delivery
        ),'text/html');

//        $message = \Swift_Message::newInstance()
//            ->setSubject('New order')
//            ->setFrom(array('plajerowy@gmail.com' => 'Shop'))
//            ->setTo(array($User->getEmail() => $User->getName() ))
//            ->setBody('');

        $message = (new \Swift_Message('You order new items'))
            ->setFrom('plajerowy@gmail.com')
            ->setTo($User->getEmail())
            ->setBody($msgBody);


        $this->get('mailer')->send($message);


        dump($Basket);
        if ($currentBought != null){
            $allBought = array_merge($currentBought, $Basket);
            $User->setBought($allBought);
        }else{
            $User->setBought($Basket);
        }
        $User->setBasket(array());
        $em = $this->getDoctrine()->getManager();
        $em->persist($Order);
        $em->persist($User);
        $em->flush();

        return $this->redirectToRoute('basket');

    }




}