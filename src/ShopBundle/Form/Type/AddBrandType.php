<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-27
 * Time: 20:35
 */

namespace ShopBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use ShopBundle\Entity\Brand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBrandType extends AbstractType
{

    public function getName(){
        return 'AddBrand';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver = array(
            'data_class' => Brand::class
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['data']->getId()){
            $builder
                ->add('name',TextType::class,array(
                    'label' => 'Label name'
                ))
                ->add('description',CKEditorType::class,array(
                    'label' => 'Label description',
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'full'
                    )
                ))
                ->add('imageFile',FileType::class,array(
                    'label' => 'Label image',
                    'required' => false
                ))
                ->add('submit',SubmitType::class,array(
                    'label' => 'Create'
                ));
        }else{
            $builder
                ->add('name',TextType::class,array(
                    'label' => 'Label name'
                ))
                ->add('description',CKEditorType::class,array(
                    'label' => 'Label description',
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'full'
                    )
                ))
                ->add('imageFile',FileType::class,array(
                    'label' => 'Label image'
                ))
                ->add('submit',SubmitType::class,array(
                    'label' => 'Create'
                ));
        }

    }

}