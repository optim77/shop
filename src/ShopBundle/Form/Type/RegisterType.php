<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-22
 * Time: 14:45
 */

namespace ShopBundle\Form\Type;
use ShopBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{


    public function getName(){
        return 'registerType';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('name',TextType::class,array(
//                'label' => 'Name'
//            ))
            ->add('username',TextType::class,array(
                'label' => 'Username'
            ))
            ->add('email',EmailType::class,array(
                'label' => 'E-mail'
            ))
            ->add('plainPassword',RepeatedType::class,array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat password')
            ))
        ->add('submit',SubmitType::class,array(
            'label' => 'Sing In'
        ));

    }

    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'data_class' => Users::class,
            'validation_group' => array('Default','Register')
        ));
    }

}