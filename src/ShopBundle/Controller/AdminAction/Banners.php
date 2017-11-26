<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-04
 * Time: 18:14
 */

namespace ShopBundle\Controller\AdminAction;

use ShopBundle\Entity\Banner;
use ShopBundle\Form\Type\AddNewBanner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class Banners extends Controller
{

    const UPLOAD_DIR = 'uploads/banners/';
    /**
     * @Route("/admin/banners", name="adminBanners")
     * @Template("ShopBundle:Settings\Banners:Banners.html.twig")
     */
    public function bannersAdminAction(){
        $Banners = $this->getDoctrine()->getRepository('ShopBundle:Banner')->findAll();
        return array(
            'banners' => $Banners
        );
    }

    /**
     * @Route("/admin/add/banner", name="addNewBanner")
     * @Template("ShopBundle:Settings\Banners:AddNewBanner.html.twig")
     */
    public function addNewBannerAction(Request $request){
        $Banner = new Banner();
        dump($Banner);
        $form = $this->createForm(AddNewBanner::class,$Banner);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($Banner);
            $em->flush();
            return $this->redirectToRoute('adminBanners');
        }
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/admin/edit/banner/{idBanner}", name="editBanner")
     * @Template("ShopBundle:Settings\Banners:AddNewBanner.html.twig")
     */
    public function editBannerAction(Request $request, $idBanner = null){
        $Banner = $this->getDoctrine()->getRepository('ShopBundle:Banner')->findById($idBanner);
        dump($Banner);
        $form = $this->createForm(AddNewBanner::class,$Banner[0]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($Banner[0]);
            $em->flush();
            return $this->redirectToRoute('adminBanners');
        }
        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/admin/delete/banner/{idBanner}", name="deleteBanner")
     */
    public function deleteBannersAction(Request $request, $idBanner){
        $Banner = $this->getDoctrine()->getRepository('ShopBundle:Banner')->findById($idBanner);
        $Image = $Banner[0]->getImage();
        $em = $this->getDoctrine()->getManager();
        $em->remove($Banner[0]);
        $em->flush();
        //unlink(__DIR__.'../../../../web/'.Banners::UPLOAD_DIR.'/'.$Image);
        return $this->redirectToRoute('addNewBanner');
    }

    /**
     * @Route("/admin/activation/banner/{idBanner}", name="activationBanner")
     */
    public function activeBannerAction($idBanner){
        $Banner = $this->getDoctrine()->getRepository('ShopBundle:Banner')->findById($idBanner);


        $content = '<a href="'.$Banner[0]->getRedirect().'"><div class="w3-display-container w3-container">
    <img src="../../web/'.$Banner[0]->getImage().'" width="100%" >
    <img src="../web/'.$Banner[0]->getImage().'" width="100%" >
    <div class="w3-display-topleft w3-text-white" style="padding:24px 48px">
        <h1 class="w3-jumbo w3-hide-small">'.$Banner[0]->getTitle().'</h1>
        <h1 class="w3-hide-large w3-hide-medium">'.$Banner[0]->getTitle().'</h1>
        <h1 class="w3-hide-small" style="font-size: 16px;">'.$Banner[0]->getDescription().'</h1>
    </div>
</div></a> ';

        $banner = __DIR__."/../../Resources/views/Template/TopLabel.html.twig";
        $file = fopen($banner,'w+');
        fwrite($file,$content);

        return $this->redirectToRoute('adminBanners');

    }

}