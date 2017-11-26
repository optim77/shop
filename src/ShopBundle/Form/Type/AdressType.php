<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-23
 * Time: 10:02
 */

namespace ShopBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\User;

class AdressType extends AbstractType
{

    public function getName(){
        return 'AdressType';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
                'label' => 'Name'
            ))
            ->add('surname',TextType::class,array(
                'label' => 'Surname'
            ))
            ->add('country',CountryType::class,array(
                'label' => 'Country'
            ))
            ->add('zipCode',TextType::class,array(
                'label' => 'Zip code'
            ))
            ->add('street',TextType::class,array(
                'label' => 'Street'
            ))
            ->add('number',TextType::class,array(
                'label' => 'Build number'
            ))
            ->add('region',TextType::class,array(
                'label' => 'Region'
            ))
            ->add('phone',NumberType::class,array(
                'label' => 'Phone number'
            ))
            ->add('submit',SubmitType::class,array(
                'label' => 'Save'
            ));
    }

    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver = array(
            'data_class' => User::class,
            'validation_group' => array('Default','SetData')
        );
    }

}