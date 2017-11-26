<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-22
 * Time: 15:24
 */

namespace ShopBundle\Controller;

use ShopBundle\Entity\User;
use ShopBundle\Form\Type\LoginType;
use ShopBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class FormsController extends Controller
{

    /**
     * @Route("/login", name="login")
     * @Template("ShopBundle:Forms:Login.html.twig")
     */
    public function loginAction(Request $request){

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class,array(
            '_username' => $lastUsername
        ));

        $Users = $this->getDoctrine()->getRepository('ShopBundle:User');

        return array(
            'form' => $form->createView(),
            'error' => $error
        );
    }

    /**
     * @Route("/register", name="register")
     * @Template("ShopBundle:Forms:Register.html.twig")
     */
    public function registerAction(Request $request){

        $Users = new User();
        $form = $this->createForm(RegisterType::class,$Users);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(null !== $Users->getId()){
                throw new Exception('That user is already exist');
            }
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($Users, $Users->getPlainPassword());
            $Users->setPassword($encoded);
            $token = substr(md5(uniqid(NULL,TRUE)),0,20);
            $Users->setActionToken($token);

            $msgBody = $this->renderView('ShopBundle:Email:Confirm.html.twig',array(
                'token' => $token
            ),'text/html');

            $message = (new \Swift_Message('You order new items'))
                ->setFrom('plajerowy@gmail.com')
                ->setTo($Users->getEmail())
                ->setBody($msgBody);

            $this->get('mailer')->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($Users);
            $em->flush();

            return $this->redirectToRoute('index');
        }



        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/confirm/{token}", name="confirm")
     */
    public function confirmAccountAction($token){

        $User = $this->getDoctrine()->getRepository('ShopBundle:User')->findByToken($token);

        $User[0]->setEnable(true);

        return $this->redirectToRoute('index');

    }

}