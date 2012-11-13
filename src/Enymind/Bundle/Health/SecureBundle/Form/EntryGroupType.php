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
            ->add('name')
            ->add('description')
            ->add('visible')
            ->add('entry_types')
            ->add('owner_id')
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
