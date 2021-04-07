<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
    
    //example: miatorta.com/tort_vkusniy_keks
    /**
     * @ORM\Column(name="url",type="string", length=255, nullable=true)
     */
    private $Url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductType", inversedBy="Products")
     * @ORM\JoinColumn(nullable=true)
     * ---@ORM\Column(name="TypeKind",type="integer")
     */
    private $TypeKind;    
    /*-*
     *- @ORM\Column(name="TypeKind",type="integer")
     */   
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductImage", mappedBy="ProductId")
     */
    private $ProductImages;    
    
    //масса за килограм
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $ProductPricePerKilogram;
    //минималоьная масса
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $ProductMinWeight;
    //максимальная масса масса
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $ProductMaxWeight;
    //шаг увеличения массы
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $ProductStepWeight;
    
    /**
     * @return int
     */
    public function getId(){
        return $this->Id;
    }
    
    /**
     * @param string $name
     * @return Product
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
     * @param string $url
     * @return Product
     */
    public function setUrl($url){
        $this->Url = $url;
        return $this;
    }
    /**
     * @return string
     */
    public function getUrl(){
        return $this->Url;
    }
    
    /**
     * @param string $description
     * @return Product
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
    

    /**
     * @param decimal $value
     * @return Product
     */
    public function setProductPricePerKilogram($value){
        $this->ProductPricePerKilogram = $value;
        return $this;
    }
    /**
     * @return decimal
     */
    public function getProductPricePerKilogram(){
        return $this->ProductPricePerKilogram;
    }  
    
    /**
     * @param decimal $value
     * @return Product
     */
    public function setProductMinWeight($value){
        $this->ProductMinWeight= $value;
        return $this;
    }
    /**
     * @return decimal
     */
    public function getProductMinWeight(){
        return $this->ProductMinWeight;
    }  
    
    /**
     * @param decimal $value
     * @return Product
     */
    public function setProductMaxWeight($value){
        $this->ProductMaxWeight = $value;
        return $this;
    }
    /**
     * @return decimal
     */
    public function getProductMaxWeight(){
        return $this->ProductMaxWeight;
    }  
    
    /**
     * @param decimal $value
     * @return Product
     */
    public function setProductStepWeight($value){
        $this->ProductStepWeight = $value;
        return $this;
    }
    /**
     * @return decimal
     */
    public function getProductStepWeight(){
        return $this->ProductStepWeight;
    }      
    
    

    /*-*
     * @param integer $typekind
     * @return Product
     */
    /*public function setTypeKind($typekind){
        $this->TypeKind = $typekind;
        return $this;
    }*/
    /*-*
     * @return int
     */
    /*public function getTypeKind(){
        return $this->TypeKind;
    }*/  
    
    /**
     * @param \App\Entity\ProductType $typekind
     * @return Product
     */
    public function setTypeKind($typekind){
        $this->TypeKind= $typekind;
        return $this;
    }
    /**
     * @return \App\Entity\ProductType
     */
    public function getTypeKind(){
        return $this->TypeKind;
    }
    
    public function __construct() {
        $this->ProductImages = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @return Collection|\App\Entity\ProductImage
     */
    public function getProductImages(){
        return $this->ProductImages;
    }      

}
