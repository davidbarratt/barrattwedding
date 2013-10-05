<?php

namespace Wedding\RespondBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('first_name', 'text');
        
        $builder->add('last_name', 'text');
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wedding\RespondBundle\Form\Model\Guest'
        ));
    }

    public function getName()
    {
        return 'attendee';
    }
    
}
