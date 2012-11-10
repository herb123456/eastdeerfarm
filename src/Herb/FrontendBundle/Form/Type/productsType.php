<?php

namespace Herb\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class productsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prodName');
        $builder->add('prodPrice');
        $builder->add('prodUnit');
        $builder->add('prodCatgory');
        $builder->add('prodPic');
        $builder->add('prodUrl');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Herb\FrontendBundle\Model\products',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'products';
    }
}
