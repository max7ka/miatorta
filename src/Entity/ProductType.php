<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="productype")
 * @ORM\Entity(repositoryClass="App\Repository\ProductTypeRepository")
 */
class ProductType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $Id;

    /**
     * @ORM\Column(name="name",type="string", length=255, nullable=true)
     */
    private $Name;
    /**
     * @ORM\Column(name="description",type="string", length=2000, nullable=true)
     */
    private $Description; 
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="TypeKind")
     */
    private $Products;
    
    /**
     * @return int
     */    
    public function getId(){
        return $this->Id;
    }
    
    /**
     * @param string $name
     * @return ProductType
     */
    public function setName($name){
        $this->Name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getName(){
        return $this->Name;
    }
    
    /**
     * @param string $description
     * @return ProductType
     */
    public function setDescription($description){
        $this->Description = $description;
        return $this;
    }
    /**
     * @return string
     */
    public function getDescription(){
        return $this->Description;
    }
    
    public function __construct() {
        $this->Products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @return Collection|\App\Entity\Product
     */
    public function getProducts(){
        return $this->Products;
    }    
    
}
