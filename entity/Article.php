<?php 
 
namespace Entity; 
 
use ORM\Entity\Entity;
use ORM\Entity\Relation;

class Article extends Entity 
{ 
    protected $id; 
    protected $title; 
    protected $content;

    //protected $Category;



    public function __construct()
    {
       // $this->Category = new Relation($this, 'Entity\\Category', Relation::ManyToOne);
    }

    public function setId($id) { 
        $this->id = $id;
    } 
 
    public function getId() { 
         return $this->id;
    } 
 
    public function setTitle($title) { 
        $this->title = $title;
    } 
 
    public function getTitle() { 
         return $this->title;
    } 
 
    public function setContent($content) { 
        $this->content = $content;
    } 
 
    public function getContent() { 
         return $this->content;
    } 
 
}