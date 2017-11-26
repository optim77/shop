<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-11
 * Time: 17:27
 */

namespace ShopBundle\Form\Type;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class ContactPageType extends AbstractType
{

    public function getName(){
        return 'ContactPageType';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field',CKEditorType::class,array(
                'label' => 'Edit',
                'config' => array(
                    'uiColor' => '#ffffff',
                    'toolbar' => 'full'
                )
            ))
            ->add('submit',SubmitType::class,array(
                'label' => 'Send'
            ));
    }

}