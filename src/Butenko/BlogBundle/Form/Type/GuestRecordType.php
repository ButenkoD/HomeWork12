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

class GuestRecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('text', 'text')
            ->add('create', 'submit');
    }

    public function getName()
    {
        return 'guestrecord';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Butenko\BlogBundle\Entity\GuestRecord',
        ));
    }
} 