<?php

namespace Profile\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ChangePasswordForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct( 'change_password' );
        $this->setAttribute( 'method', 'post' );
        $this->setAttribute( 'class', 'form-horizontal' );
        
        $this->add( [ 'name' => 'password',
            'attributes' => [
                'type'  => 'password',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'New Password',
            ],
        ]);
        
        $this->add( [ 'name' => 'ret_password',
            'attributes' => [
                'type'  => 'password',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Confirm Password',
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
                
        $this->add( [
            'name' => 'submit_pwd',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Update',
                'id' => 'submit_change_password',
                'class' => 'btn btn-primary'
            ],
        ]);
        
        $this->setupFilters();
    }
    
    public function setupFilters()
    {
        $inputFilter = new InputFilter();
    
        $inputFilter->add( [
            'name'     => 'password',
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
        
        $inputFilter->add( [
            'name'     => 'ret_password',
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