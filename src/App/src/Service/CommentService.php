<?php
namespace App\Service;

use App\Entity\Comment;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;


class CommentService {
     
    private $em;

    public function __construct(EntityManagerInterface $em) { 
        $this->em = $em;
        
    }

    public function getCommentsOnPost($id) {
        $query = $this->em->createQuery('SELECT c,u FROM App\Entity\Comment c INNER JOIN c.user u WHERE c.post=:id');
        $query->setParameter('id',$id);
        return $query->getResult(Query::HYDRATE_ARRAY);

    }
    public function addComment(Comment $c) {
        
        $this->em->persist($c);
        $this->em->flush();
    }




}