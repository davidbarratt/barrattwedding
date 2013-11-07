<?php

namespace Wedding\RespondBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Wedding\RespondBundle\Form\Type\GuestType;

class RespondRehearsalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    
        $builder->add('attending', 'choice', array(
          'choices' => array(
            1 => "Yes",
            0 => "No"
          ),
          'expanded' => TRUE,
          'label'  => 'Coming to the Rehearsal Dinner?',
        ));
        
        $builder->add('first_name', 'text');
        
        $builder->add('last_name', 'text');
        
        $builder->add('email', 'email');
        
        $builder->add('phone', 'text');
        
        $builder->add('guest', 'collection', array(
          'label' => 'Please list all additional guests.',
          'type'  => new GuestType(),
          'allow_add' => TRUE,
          'prototype' => TRUE,
        ));
        
        $builder->add('note', 'textarea', array(
          'label' => "Anything else you'd like to say?",
          'required' => FALSE,
        ));
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wedding\RespondBundle\Form\Model\RespondRehearsal'
        ));
    }

    public function getName()
    {
        return 'respond';
    }
}
