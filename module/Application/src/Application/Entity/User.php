<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class User 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", lenght=32) */
    protected $username;
    
    /** @ORM\Column(type="string", lenght=32) */
    protected $password;
    
    /** @ORM\Column(type="string", lenght=10) */
    protected $status;
                                
    // getters/setters
}