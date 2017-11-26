<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-22
 * Time: 12:25
 */

namespace ShopBundle\Form\Type;


use ShopBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{

    public function getName(){
        return 'loginType';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('_username',TextType::class,array(
                'label' => 'Username'
            ))
            ->add('_password',PasswordType::class,array(
                'label' => 'Password'
            ))
            ->add('_remember_me',CheckboxType::class,array(
                'label' => 'Remember me',
                'required' => false
            ))
            ->add('submit',SubmitType::class,array(
                'label' => 'Login'
            ));
    }

    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'data_class' => Users::class,
            'validation_group' => array('Default','Login')
        ));
    }


}