<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;

class CategoryService {
    
    private $orm;

    public function __construct(EntityManagerInterface $orm) {
        $this->orm = $orm;
    }

    public function getCategoryById($id) {
        return $this->orm->find(Category::class,$id);
    }
    public function getAllCategories() {
        $rcrds = $this->orm->getRepository(Category::class)->findAll();
        return $rcrds;
    }
 

}

