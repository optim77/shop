<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-04
 * Time: 14:37
 */

namespace ShopBundle\Form\Type;
use ShopBundle\Entity\Deliver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class AddDeliveryType extends AbstractType
{

    public function getName(){
        return 'DeliveryType';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if ($options['data']->getId()){
            $builder
                ->add('name',TextType::class,array(
                    'label' => 'Name delivery'
                ))
                ->add('description', TextareaType::class,array(
                    'label' => 'Description delivery'
                ))
                ->add('timeToDeliver',TextType::class,array(
                    'label' => 'Delivery time'
                ))
                ->add('cost',NumberType::class,array(
                    'label' => 'Cost'
                ))
                ->add('image',TextType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('submit', SubmitType::class,array(
                    'label' => 'Create'
                ));
        }else{
            $builder
                ->add('name',TextType::class,array(
                    'label' => 'Name delivery'
                ))
                ->add('description', TextareaType::class,array(
                    'label' => 'Description delivery'
                ))
                ->add('timeToDeliver',TextType::class,array(
                    'label' => 'Delivery time'
                ))
                ->add('cost',NumberType::class,array(
                    'label' => 'Cost'
                ))
                ->add('image',TextType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('submit', SubmitType::class,array(
                    'label' => 'Create'
                ));
        }


    }

    public function getDefaultsOptions(OptionsResolver $resolver){
        $resolver = array(
            'data_class' => Deliver::class
        );
    }

}