<?php

namespace Enymind\Bundle\Health\SecureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('isActive')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enymind\Bundle\Health\SecureBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'enymind_bundle_health_securebundle_usertype';
    }
}
