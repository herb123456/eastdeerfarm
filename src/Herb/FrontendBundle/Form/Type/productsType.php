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
        // $builder->add('prodName', 'text');
        // $builder->add('prodPrice', 'text');
        // $builder->add('prodUnit', 'text');
        // $builder->add('prodCatgory', 'model', array(
        //                                         'class' => 'Herb\FrontendBundle\Model\productType',
        //                                         'property'  => 'ptName',));
        // $builder->add('prodPic', 'file');
        // $builder->add('prodUrl', 'text', array("required" => false));

        $catgorys = $options['catgorys'];
        $catgory_default = $options['catgory_default'];

        $builder->add('prodName', 'text');
        $builder->add('prodPrice', 'text', array('max_length' => 10));
        $builder->add('prodUnit', 'text', array('max_length' => 10));
        $builder->add('prodCatgory', 'choice', array(
                                                'choices' => $catgorys,));
        $builder->add('prodPic', 'file');
        $builder->add('prodUrl', 'text', array("required" => false));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Herb\FrontendBundle\Model\products',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'products',
            'catgorys' => array(),
            'catgory_default' => 0,
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
