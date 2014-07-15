<?php

namespace Auth\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class LoginForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct( 'login' );
        $this->setAttribute( 'method', 'post' );
        $this->setAttribute( 'class', 'form-horizontal' );
        
        $this->add( [ 'name' => 'username',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Username',
            ],
        ]);
        
        $this->add( [ 'name' => 'password',
            'attributes' => [
                'type'  => 'password',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);
        
        $this->add( [ 'name' => 'rememberme',
            //'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => [
                'type'  => 'hidden',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Rmemeber me?',
            ],
        ]);
        
        //$actions = new Collection( 'actions' );
        //$actions->setAttirbute( 'class', 'actions' );
        
        $this->add( [
            'name' => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Log In',
                'id' => 'login',
                'class' => 'btn btn-primary'
            ],
        ]);
        
        $this->setupFilters();
    }
    
    public function setupFilters()
    {
        $inputFilter = new InputFilter();
    
        $inputFilter->add( [
            'name'     => 'username',
            'required' => true,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
    
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
            
        $this->setInputFilter( $inputFilter );
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
}