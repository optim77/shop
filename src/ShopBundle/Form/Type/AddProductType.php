<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-28
 * Time: 12:54
 */

namespace ShopBundle\Form\Type;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use ShopBundle\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AddProductType extends AbstractType
{
    public function getName(){
        return 'AddStuff';
    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver = array(
            'allow_extra_fields' => true,
            'data_class' => Products::class
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver = array(
            'allow_extra_fields' => true
        );
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        if(isset($options['data']) && $options['data']->getId() != null){

           //dump($options['data'][0]->getBrand());
            $DefaultBrand = $options['data']->getBrand();
            $IdDefaultBrand = $DefaultBrand->getId();
            $NameDefaultBrand = $DefaultBrand->getName();

            $DefaultCategory = $options['data']->getCategory();
            $IdDefaultCategory = $DefaultCategory->getId();
            $NameDefaultCategory = $DefaultCategory->getName();
            $builder
                ->add('name',TextType::class,array(
                    'label' => 'Name product',
                    'data' => $options['data']->getName()
                ))
                ->add('description',CKEditorType::class,array(
                    'label' => 'Description',
                    'data' => $options['data']->getDescription(),
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'full'
                    )
                ))
                ->add('amounts',IntegerType::class,array(
                    'label' => 'Amount'
                ))
                ->add('imageFile',FileType::class,array(
                    'label' => 'Main picture',
                    'required' => false
                ))
                ->add('imageFile2',FileType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('imageFile3',FileType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('publishDate',DateType::class,array(
                    'label'=> 'Publish date',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'data' => $options['data']->getpublishDate()
                ))
                ->add('prize',TextType::class,array(
                    'label' => 'Prize',
                    'data' => $options['data']->getPrize()
                ))
                ->add('submit',SubmitType::class,array(
                    'label' => 'Add'
                ));
        }else{


            $builder
                ->add('name',TextType::class,array(
                    'label' => 'Name product'
                ))
                ->add('description',CKEditorType::class,array(
                    'label' => 'Description',
                    'config' => array(
                        'uiColor' => '#ffffff',
                        'toolbar' => 'full'
                    )
                ))
                ->add('amounts',IntegerType::class,array(
                    'label' => 'Amount'
                ))
                ->add('imageFile',FileType::class,array(
                    'label' => 'Main picture'
                ))
                ->add('imageFile2',FileType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('imageFile3',FileType::class,array(
                    'label' => 'Image',
                    'required' => false
                ))
                ->add('publishDate',DateType::class,array(
                    'label'=> 'Publish date',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'data' => new \DateTime()
                ))
                ->add('prize',TextType::class,array(
                    'label' => 'Prize'
                ))
                ->add('submit',SubmitType::class,array(
                    'label' => 'Add'
                ));
        }


    }



}