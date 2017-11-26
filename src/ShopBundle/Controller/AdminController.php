<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-24
 * Time: 20:21
 */

namespace ShopBundle\Controller;


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

class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin")
     * @Template("ShopBundle:Admin:Admin.html.twig")
     */
    public function adminAction(){
        $User = $this->getUser();
        $roles = $User->getRoles();
        if($roles[0] == "ROLE_ADMIN"){

        }else{
            return $this->redirectToRoute('index');
        }

        return array();

    }



    /**
     * @Route("/admin/users/{page}", name="adminUsers")
     * @Template("ShopBundle:Admin:Users.html.twig")
     */
    public function usersSettingAdminAction(Request $request ,$page = 1){
        $queryParams = array(
            'search' => $request->query->get('search'),
        );
        $Users = $this->getDoctrine()->getRepository('ShopBundle:User');
        $qb = $Users->getQueryBuilder($queryParams);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb, /* query NOT result */
            $page,
            20/*limit per page*/
        );
        return array(
            'users' => $pagination,
            'queryParams' => $queryParams
        );
    }


    /**
     * @Route("/admin/delete/{type}/{item}", name="deleteAdmin")
     */
    public function deleteAdminAction($type = null, $item = null){

        if($type != null && $type == 'category'){
            $Category = $this->getDoctrine()->getRepository('ShopBundle:Category')->findBySlug($item);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Category[0]);
            $em->flush();
            return $this->redirectToRoute('editCategory');
        }
        elseif ($type != null && $type == 'brand' ){
            $Brand = $this->getDoctrine()->getRepository('ShopBundle:Brand')->findBySlug($item);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Brand[0]);
            $em->flush();
            return $this->redirectToRoute('editBrand');
        }elseif ($type != null && $type == 'product'){
            $Product = $this->getDoctrine()->getRepository('ShopBundle:Products')->findBySlug($item);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Product[0]);
            $em->flush();
            return $this->redirectToRoute('editStuff');
        }
        else{
            return $this->redirectToRoute('editCategory');
        }

    }


    static public function slugify($text)
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

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}