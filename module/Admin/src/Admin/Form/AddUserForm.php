<?php

namespace Admin\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AddUserForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct( 'profile_data' );
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
        
        $this->add( [ 'name' => 'name',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);
        
        $this->add( [ 'name' => 'customers_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type'  => 'select',
                'class' => 'form-control chzn-select'
            ],
            'options' => [
                'label' => 'Customer',
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
        
        $this->add( [ 'name' => 'read_only',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => [
                'type'  => 'checkbox',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Read only',
            ],
        ]);
                                                                                                                            
        
        $this->add( [ 'name' => 'password',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);
        
        //$actions = new Collection( 'actions' );
        //$actions->setAttirbute( 'class', 'actions' );
        
        $this->add( [
            'name' => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submit_add_user',
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