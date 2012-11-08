<?php

namespace Enymind\Bundle\Health\SecureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('min', 'number')
            ->add('max', 'number')
            ->add('quantity', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enymind\Bundle\Health\SecureBundle\Entity\EntryType'
        ));
    }

    public function getName()
    {
        return 'enymind_bundle_health_securebundle_entrytypetype';
    }
}
