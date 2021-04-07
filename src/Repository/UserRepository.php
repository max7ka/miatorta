<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/*class UserRepository extends ServiceEntityRepository*/
/*use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;*/

class UserRepository extends ServiceEntityRepository// implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /*public function byLogin($login)
    {
        return $this->createQueryBuilder('u')
            ->where('u.Login = :login')->setParameter('login', $login)
            ->getQuery()
            ->getScalarResult();
    } */
    
    public function loadUserByUsername($username){
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }  

    public function byUserName($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()->getSingleResult();
    } 
    
    public function All(){
        return $this->createQueryBuilder('u')
            ->select('u.username,u.email,u.roles')
            ->getQuery()
            ->getScalarResult();
    }      
    
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
