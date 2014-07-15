<?php

namespace Profile\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ProfileDataForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct( 'profile_data' );
        $this->setAttribute( 'method', 'post' );
        $this->setAttribute( 'class', 'form-horizontal' );
        
        $this->add( [ 'name' => 'name',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);
        
        $this->add( [ 'name' => 'email',
            'attributes' => [
                'type'  => 'email',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Email',
            ],
        ]);
        
        $this->add( [ 'name' => 'username',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Username',
            ],
        ]);
        
        $this->add( [ 'name' => 'conf_password',
            'attributes' => [
                'type'  => 'password',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Current Password',
            ],
        ]);
        
        //$actions = new Collection( 'actions' );
        //$actions->setAttirbute( 'class', 'actions' );
        
        $this->add( [
            'name' => 'submit_data',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Update',
                'id' => 'submit_profile_data',
                'class' => 'btn btn-primary'
            ],
        ]);
        
        $this->setupFilters();
    }
    
    public function setupFilters()
    {
        $inputFilter = new InputFilter();
        
        $inputFilter->add( [
            'name'     => 'name',
            'required' => true,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
        
        $inputFilter->add( [
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'validators' => [
                [ 'name' => 'EmailAddress' ],
            ],
        ]);
    
        $inputFilter->add( [
            'name'     => 'username',
            'required' => true,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
    
        $inputFilter->add( [
            'name'     => 'conf_password',
            'required' => true,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'validators' => [
                [ 'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                    ],
                ],
            ],
        ]);
            
        $this->setInputFilter( $inputFilter );
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
}