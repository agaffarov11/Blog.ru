<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post {

    /** 
     * 
     * 
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $linkdesc;


     /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;


     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $shortdesc;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $main_text;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="post")
     */
    private $category;

    /** 
     *  @ORM\OneToMany(targetEntity="Comment", mappedBy="post",cascade={"remove"})
     */ 
    private $comments;


    public function __construct($linkdesc,$date,$shortdesc,$mainText,$category) {
        $this->comments = new ArrayCollection();

        $this->linkdesc = $linkdesc;
        $this->date = $date;
        $this->shortdesc = $shortdesc;
        $this->main_text = $mainText;
        $this->category = $category;
    }

    public function getCategory() {
        return $this->category;
    }
    public function getShortdesc() {
        return $this->shortdesc;
    }
    public function getLinkdesc() {
        return $this->linkdesc;
    }
    public function getMain_text() {
        return $this->main_text;
    }
    public function getDate() {
        return date_format($this->date,'Y-m-d H:i:s');
    }
    public function getId() {
        return $this->id;
    }

    public function addComment(Comment $comment) {
        $comment->setPost($this);
        if(!$this->comments->contains($comment)) {
           $this->comments->add($comment);
        }
    }
    public function removeComment(Comment $comment) {
       $this->comments->removeElement($comment);
    }

    


}