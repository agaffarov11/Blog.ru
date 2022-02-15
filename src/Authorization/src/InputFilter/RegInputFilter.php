<?php

namespace Authorization\InputFilter;

use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class RegInputFilter extends InputFilter {
   
    public function init() 
    {

        $login = new Input("login");
        $login->getValidatorChain()->attach(new EmailAddress());

        $firstName = new Input("fname");
        $firstName->getValidatorChain()->attach(new StringLength(3,12));

        $lastName = new Input("lname");
        $lastName->getValidatorChain()->attach(new StringLength(3,12));

        $password = new Input("password");
        $password->getValidatorChain()->attach(new StringLength(3,12));

        
        
         
        $this->add($login);
        $this->add($firstName);
        $this->add($lastName);
        $this->add($password);

        

        

        
       
        
        


        /** 
         
         $this->setValidationGroup(['fname','lname']);
        

        $this->add([
            'name' => 'login',
            'required' => true,
            'validators' => [
                [
                    'name' => NotEmpty::class,
                ],
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 4
                    ],
                ],
                [
                    'name' => EmailAddress::class,
                    
                ],
            ],
        ]);
        */
        
        
        
    }
}