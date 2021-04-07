<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="productimage")
 * @ORM\Entity(repositoryClass="App\Repository\ProductImageRepository")
 */
class ProductImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $Id;

    /*-*
     *- @ORM\Column(name="productid",type="integer", nullable=true)
     */
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="ProductImages")
     * @ORM\JoinColumn(nullable=true)
     * ---@ORM\Column(name="productid",type="integer")
     */    
    private $ProductId;
    
    /**
     * @ORM\Column(name="name",type="string", length=255, nullable=true)
     */
    private $Name;
    
    /**
     * @ORM\Column(name="description",type="string", length=2000, nullable=true)
     */
    private $Description;   
    
    public function getId(){
        return $this->Id;
    }
    
    /**
     * @param integer $productid
     * @return ProductImage
     */
    public function setProductId($productid){
        $this->ProductId = $productid;
        return $this;
    }
    /**
     * @return integer
     */
    public function getProductId(){
        return $this->ProductId;
    }    
    
    /**
     * @param string $name
     * @return ProductImage
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
     * @return ProductImage
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
}
