<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment {

    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /** 
     *@ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * 
     */ 
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commentsAuthored")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     */
    private $comment_text;


    /** 
    public function __construct($comment_text,Post $p,User $u) {
         $this->comment_text = $comment_text;
         $this->post = $p;
         $this->user = $u;
    }
    */

    public function getComment_text() {
        return $this->comment_text;
    }
    public function getUser() {
        return $this->user;
    }
    public function getPost() {
        return $this->post;
    }
    public function setPost(Post $p) {
       $this->post = $p;
    }
    public function setUser(User $u) {
        $this->user = $u;
    }
    public function setCommentText($t) {
         $this->comment_text = $t;
    }
    



}