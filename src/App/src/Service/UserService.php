<?php

namespace App\Service;

use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserService implements UserRepositoryInterface {

    private $em;
    private $userFactory;

    public function __construct(EntityManagerInterface $orm,callable $userFactory) {
        $this->em = $orm;

        $this->userFactory = static function (
            string $identity,
            array $roles = [],
            array $details = []
        ) use ($userFactory): UserInterface {
            

            return $userFactory($identity, $roles, $details);
        };
    }

    public function addUser($userArray) {
        $password = password_hash($userArray['password'],PASSWORD_BCRYPT);
        $u = new User($userArray['login'],$userArray['fname'],$userArray['lname'],$password);
        $this->em->persist($u);
        $this->em->flush();
    }
    public function checkEmail($email) {
       $query = $this->em->createQuery("SELECT u.login FROM App\Entity\User u WHERE u.login= ?1 ");
       $query->setParameter(1,$email);
       $arr= $query->getResult();
       if(empty($arr)) {
           return true;
       }
       return false;
    }
    public function getUserByEmail($email) {
         
       $user = $this->em->getRepository('App\Entity\User')->findBy(array('login' => $email));
       
      return $user;
    }

    ///////changes
    //removed userinterface return
    /**
     * {@inheritDoc}
     */
    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        $query = $this->em->createQuery("SELECT u.password FROM App\Entity\User u WHERE u.login=?1");
        $query->setParameter(1,$credential);
        $result = $query->getResult();
        if($result==null) {
            return null;
        }
        $passwordHash = $result[0]['password'];
        if(password_verify($password,$passwordHash)) {
            return ($this->userFactory)(
                $credential,
                $this->getUserRoles($credential),
                $this->getUserDetails($credential)
            );
        }

         
        return null;
    }
    public function getUserRoles(string $identity) {
        $query = $this->em->createQuery("SELECT u.role FROM App\Entity\User u WHERE u.login=?1");
        $query->setParameter(1,$identity);
        $result = $query->getResult();
        return array($result[0]['role']);

    }
    public function getUserDetails(string $identity) {
        return array();

    }
    public function deleteUserById() {
        
    }



}