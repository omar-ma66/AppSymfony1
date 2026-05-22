<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByCategory(Category $category):array
    {
        return $this->createQueryBuilder('b')
                    ->join('b.categories','c')
                    ->andWhere('c = :category')
                    ->setParameter('category',$category)
                    ->orderBy('b.title','ASC')
                    ->getQuery()
                    ->getResult();
    }
    public function findByStock(int $nb):array
    {
       return $this->createQueryBuilder('b')
             ->andWhere("b.stock >  :nb ")
             ->setParameter("nb",$nb)
             ->orderBy('b.title','ASC')
             ->getQuery()
             ->getResult();
    }

    public function findByAuteur(Auteur $auteur):array
    {
           return     $this->createQueryBuilder('b')
                     ->andWhere('b.author = :author')
                    ->setParameter('author',$auteur)
                    ->orderBy('b.title','ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function findByTitleLike(string $search): array
{
    return $this->createQueryBuilder('b')
        ->andWhere('b.title LIKE :search')
        ->setParameter('search', '%' . $search . '%')
        ->orderBy('b.title', 'ASC')
        ->getQuery()
        ->getResult();
}

}
