<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-25
 * Time: 20:09
 */

namespace ShopBundle\Form\Type;
use ShopBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCategory extends AbstractType
{

    public function getName(){
        return 'AddProduct';
    }


    public function getBlockPrefix()
    {
        return null;
    }

    public function setDefaultsOption(OptionsResolver $resolver){
        $resolver = array(
            'data_class' => Category::class
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
                'label' => 'Name category'
            ))
            ->add('imageFile',FileType::class,array(
                'label' => 'Image'
            ))
            ->add('submit',SubmitType::class,array(
                'label' => 'Add category'
            ));
    }

}