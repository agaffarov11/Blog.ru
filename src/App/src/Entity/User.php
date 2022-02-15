<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {

    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * 
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string",unique=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string")
     */
    private $fname;
    
    /**
    * @ORM\Column(type="string")
    */
    private $lname;
    
    /**
     * @ORM\Column(type="string",length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     */
    private $role;

     /**
      *@ORM\OneToMany(targetEntity="Comment", mappedBy="user")
      */
    private $commentsAuthored;

    public function __construct($login,$fname,$lname,$password) {
       $this->login = $login;
       $this->fname = $fname;
       $this->lname = $lname;
       $this->password = $password;
       $this->role = 'user'; 

       

    }

    public function getLogin() {
        return $this->login;
    }
    public function getFname() {
        return $this->fname;
    }
    public function getLname() {
        return $this->lname;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getRole() {
        return $this->role;
    }


}