<?php

namespace App\Repository;

use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductImage::class);
    }
    
    //array простых классов
    public function byProdId($prodid)
    {
        return $this->createQueryBuilder('p')
            ->where('p.ProductId = :prodid')->setParameter('prodid', $prodid)
            ->getQuery()
            ->getScalarResult();
    }  
    
    //изображения продукта по типу
    public function byTypeId($typeid)
    {
        //к каждому изображ подвязываем продакт
        return $this->createQueryBuilder('i')
            //->where('p.Id = :id')->setParameter('id', $id)
            ->where('p.TypeKind = :typeid')->setParameter('typeid', $typeid)
            //->select('i','p')//,'count(im)as imagecnt'
            ->select('i')
            ->leftJoin('i.ProductId', 'p')
            //->leftJoin('p.ProductImages', 'im')
            ->getQuery()
            ->getScalarResult();        
    }   
    
    public function Limit()
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->leftJoin('i.ProductId', 'p')
            ->setMaxResults(16)
            ->getQuery()
            ->getScalarResult();
    }     
    
    //return array object
    public function GetProductImagesByProdId($prodid)
    {
        return $this->createQueryBuilder('p')
            ->where('p.ProductId = :prodid')->setParameter('prodid', $prodid)
            ->getQuery()
            ->getResult();
    }     

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
