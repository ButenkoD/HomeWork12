<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 1/7/14
 * Time: 7:48 PM
 */

namespace Butenko\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
//            ->add('category', new CategoryType())
            ->add('category', 'entity', array(
            'class' => 'ButenkoBlogBundle:Category',
            'property' => 'name',
            'multiple' => false,
            'expanded' => false,
            'empty_value' => ''
            ))
            ->add('tags', 'collection', array(
                'type' => new TagType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ))
            ->add('create', 'submit');
    }

    public function getName()
    {
        return 'article';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Butenko\BlogBundle\Entity\Article',
        ));
    }
} 