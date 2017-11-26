<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-23
 * Time: 09:58
 */

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Users;
use ShopBundle\Form\Type\AdressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{

    /**
     * @Route("/profile", name="profile")
     * @Template("ShopBundle:Profile:Profile.html.twig")
     */
    public function profileAction(Request $request){
        $User = $this->getUser();

        if ($User !== null){
            $form = $this->createForm(AdressType::class,$User);
            dump($User);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $User = $this->getUser();

                $em = $this->getDoctrine()->getManager();
                $em->persist($User);
                $em->flush();

            }

            return array(
                'form' => $form->createView()
            );
        }else{
            return $this->redirectToRoute('index');
        }

    }

}