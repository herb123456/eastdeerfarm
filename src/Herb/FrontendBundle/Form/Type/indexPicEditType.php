<?php

namespace Herb\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class indexPicEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ipFilename', "file", array("required" => false));
        $builder->add('ipDescription', "textarea", array("required" => false));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Herb\FrontendBundle\Model\indexPic',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'indexpic',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'indexpic';
    }
}
