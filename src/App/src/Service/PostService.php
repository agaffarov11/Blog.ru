<?php
namespace App\Service;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;

class PostService
{
    private $orm;


    public function __construct(EntityManagerInterface $orm) {
        $this->orm = $orm;
    }
 
    public function getAllPosts() {
       $rcrds = $this->orm->getRepository(Post::class)->findAll();
       return $rcrds;
    }
    public function getAllPosts2() {
        $query = $this->orm->createQuery("SELECT p FROM App\Entity\Post p");
        return $query->getResult(Query::HYDRATE_ARRAY);
    }

    public function getPostById($id) {
        return $this->orm->find(Post::class,$id);
    }
    public function getPostsByCategory($category) {
       $query = $this->orm->createQuery('SELECT p,c FROM App\Entity\Post p INNER JOIN p.category c WHERE c.name = :name');
       $query->setParameter('name',$category);
       return $query->getResult();

    }

    public function getNumberOfPosts() {
        $dql = $this->orm->createQuery('SELECT COUNT(u.id) FROM App\Entity\Post u');
        $count = $dql->getSingleScalarResult();
        return $count;
    }

    public function getPostsWithLimit($offset,$limit,$category) {
       
        if($category==null) { 
           $dql = "SELECT p FROM App\Entity\Post p ORDER BY p.date DESC";
           $query = $this->orm->createQuery($dql)
                       ->setFirstResult($offset)
                       ->setMaxResults($limit);
        }else {
            $dql = "SELECT p,c FROM App\Entity\Post p INNER JOIN p.category c WHERE c.name = :name ORDER BY p.date DESC";
            $query = $this->orm->createQuery($dql)->setParameter('name',$category)
                       ->setFirstResult($offset)
                       ->setMaxResults($limit);
        }
        


        $paginator = new Paginator($query, $fetchJoinCollection = true);  

        
        return $paginator;           
        
    }
    public function addPost($linkdesc,$date,$shortdesc,$mainText,$category) {
        $p = new Post($linkdesc,$date,$shortdesc,$mainText,$category);
        $this->orm->persist($p);
        $this->orm->flush();
        return $p->getId();
    }
    


  
}