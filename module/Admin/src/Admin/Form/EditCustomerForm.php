<?php

namespace Admin\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EditCustomerForm extends Form
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
        
        //FIXME: drop down list
        $this->add( [ 'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type'  => 'select',
                'class' => 'form-control chzn-select'
            ],
            'options' => [
                'label' => 'Type',
            ],
        ]);
        
        $this->add( [ 'name' => 'contact',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Contact',
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
          
        $this->add( [ 'name' => 'address_line1',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Address',
            ],
        ]);
        
        $this->add( [ 'name' => 'address_line2',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => '',
            ],
        ]);
        
        $this->add( [ 'name' => 'city',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'City',
            ],
        ]);
        
        $this->add( [ 'name' => 'state',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'State/County',
            ],
        ]);
        
        //FIXME: dropdown countries with default contry set in configurations or geoip
        $this->add( [ 'name' => 'country',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type'  => 'select',
                'class' => 'form-control chzn-select'
            ],
            'options' => [
                'label' => 'Country',
            ],
        ]);
                
        //$actions = new Collection( 'actions' );
        //$actions->setAttirbute( 'class', 'actions' );
        
        $this->add( [
            'name' => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submit_edit_customer',
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
            'name'     => 'type',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
        
        $inputFilter->add( [
            'name'     => 'contact',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
        
        $inputFilter->add( [
            'name'     => 'email',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'validators' => [
                [ 'name' => 'EmailAddress' ],
            ],
        ]);
    
        $inputFilter->add( [
            'name'     => 'address_line1',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
        
        $inputFilter->add( [
            'name'     => 'address_line2',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ]
        ]);
    
        $inputFilter->add( [
            'name'     => 'city',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
        ]);
        
        $inputFilter->add( [
            'name'     => 'state',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
        ]);
        
        //FIXME: dropdown countries with default contry set in configurations
        $inputFilter->add( [
            'name'     => 'country',
            'required' => false,
            'filters'  => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
        ]);
            
        $this->setInputFilter( $inputFilter );
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
}