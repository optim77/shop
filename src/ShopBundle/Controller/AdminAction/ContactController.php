<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-11
 * Time: 16:45
 */

namespace ShopBundle\Controller\AdminAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Form\Type\ContactPageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    /**
     * @Route("/admin/contact", name="AdminContact")
     * @Template("ShopBundle:Settings\Contact:Contact.html.twig")
     */
    public function contactAdminAction(Request $request){

        $form = $this->createForm(ContactPageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            dump($_POST);
            $content = '{% extends "ShopBundle:BASE:base.html.twig" %}
        {% block subscribe %}{% endblock %}
        {% block title %}{% trans %}Contact{% endtrans %}{% endblock %}
        {% block section %}{% trans %}Contact{% endtrans %}{% endblock %}
        {% block mainContent %}'.$_POST['field'].'
        {% endblock %}';
            $contact = __DIR__."/../../Resources/views/Template/Contact.html.twig";
            $file = fopen($contact,'w+');
            fwrite($file,$content);
            return $this->redirectToRoute('contact');
        }
        return array(
            'form' => $form->createView()
        );
    }

}