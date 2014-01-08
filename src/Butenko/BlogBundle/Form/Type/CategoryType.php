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

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    public function getName()
    {
        return 'category';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Butenko\BlogBundle\Entity\Category',
        ));
    }
} 