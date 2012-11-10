<?php

namespace Herb\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class farmVideoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fvCode');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Herb\FrontendBundle\Model\farmVideo',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'farmvideo';
    }
}
