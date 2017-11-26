<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-04
 * Time: 20:04
 */

namespace ShopBundle\Form\Type;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use ShopBundle\Entity\Banner;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class AddNewBanner extends AbstractType
{

    public function getName(){
        return 'BannerType';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function setDefaultsOptions(OptionsResolver $resolver){
        $resolver = array(
            'data_class' => Banner::class
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['data']->getId()){
            $builder
                ->add('title',TextType::class,array(
                    'label' => 'Title'
                ))
                ->add('description',CKEditorType::class,array(
                    'label' => 'Description banner',
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'full'
                    )
                ))
                ->add('redirect',TextType::class,array(
                    'label' => 'Redirect'
                ))
                ->add('imageFile',FileType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('submit',SubmitType::class,array(
                    'label' => 'Create'
                ));
        }else{
            $builder
                ->add('title',TextType::class,array(
                    'label' => 'Title'
                ))
                ->add('description',CKEditorType::class,array(
                    'label' => 'Description banner',
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'full'
                    )
                ))
                ->add('redirect',TextType::class,array(
                    'label' => 'Redirect'
                ))
                ->add('imageFile',FileType::class,array(
                    'label' => 'Image'
                ))
                ->add('submit',SubmitType::class,array(
                    'label' => 'Create'
                ));
        }


    }
}