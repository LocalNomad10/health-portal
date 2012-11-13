<?php

namespace Enymind\Bundle\Health\SecureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('visible', 'checkbox')
            ->add('entry_types', 'entity', array(
                    'class' => 'EnymindHealthSecureBundle:EntryType',
                    'property' => 'name',
                    'multiple' => true,
                    'expanded' => true
                 ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enymind\Bundle\Health\SecureBundle\Entity\EntryGroup'
        ));
    }

    public function getName()
    {
        return 'enymind_bundle_health_securebundle_entrygrouptype';
    }
}
