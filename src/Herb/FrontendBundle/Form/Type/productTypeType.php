<?php

namespace Herb\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class productTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ptName');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Herb\FrontendBundle\Model\productType',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'producttype';
    }
}
