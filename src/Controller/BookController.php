<?php

namespace App\Controller;
use App\Entity\Auteur;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CategoryRepository;
use App\Repository\BookRepository;

final class BookController extends AbstractController
{

#[Route('/livre/ajouter' , name:'app_add_book')]
public function addBook(EntityManagerInterface $em ,CategoryRepository $cr ):Response
{
 $classique = $cr->find(3)  ;
 $sf = $cr->find(1)  ;
 $dy = $cr->find(2)  ;

 $petitPrince = new  Book();
 $antoine     = new Auteur();
 $antoine->setFirstName("Antoine");
 $antoine->setLastName("de Saint-Exupéry");

 $petitPrince->setTitle("le petit prince");
 $petitPrince->setAuthor($antoine);
 $petitPrince->setDescription("un livre plein de poesie");
 $petitPrince->setStock(4);
 $petitPrince->addCategory($classique);


 $fahr = new  Book();
 $ray     = new Auteur();
 $ray->setFirstName("Ray");
 $ray->setLastName("Bradbury");

 $fahr->setTitle("Fahrenheit 451");
 $fahr->setAuthor($ray);
 $fahr->setDescription("un livre extra qui laisse réfléchir");
 $fahr->setStock(3);
 $fahr->addCategory($classique);        
 $fahr->addCategory($dy);        
          
  
 //dd($fahr , $petitPrince ,$ray ,$antoine );
   
 $em->persist($antoine);  
 $em->persist($petitPrince);

 $em->persist($fahr);
 $em->persist($ray);

 $em->flush();
 
return new Response( "les deux livres sont enregistrés");

}



// #[Route('/livres/init', name: 'app_book_init')]
// public function init(EntityManagerInterface $em): Response
// {
//     // 1. Créer des auteurs
//     $herbert = new Auteur();
//     $herbert->setFirstName('Frank');
//     $herbert->setLastName('Herbert');

//     $orwell = new Auteur();
//     $orwell->setFirstName('George');
//     $orwell->setLastName('Orwell');

//     $asimov = new Auteur();
//     $asimov->setFirstName('Isaac');
//     $asimov->setLastName('Asimov');

//     // 2. Créer des catégories
//     $sf = new Category();
//     $sf->setName('Science-Fiction');

//     $dystopie = new Category();
//     $dystopie->setName('Dystopie');

//     $classique = new Category();
//     $classique->setName('Classique');

//     // 3. Créer des livres avec leurs relations
//     $dune = new Book();
//     $dune->setTitle('Dune');
//     $dune->setDescription('Un chef-d\'œuvre de la science-fiction.');
//     $dune->setStock(5);
//     $dune->setAuthor($herbert);           // ManyToOne
//     $dune->addCategory($sf);              // ManyToMany
//     $dune->addCategory($classique);       // ManyToMany

//     $book1984 = new Book();
//     $book1984->setTitle('1984');
//     $book1984->setDescription('Un roman d\'anticipation de George Orwell.');
//     $book1984->setStock(3);
//     $book1984->setAuthor($orwell);
//     $book1984->addCategory($dystopie);
//     $book1984->addCategory($classique);

//     $fondation = new Book();
//     $fondation->setTitle('Fondation');
//     $fondation->setDescription('Le début de la saga Fondation.');
//     $fondation->setStock(2);
//     $fondation->setAuthor($asimov);
//     $fondation->addCategory($sf);

//     // 4. Persister toutes les entités
//     $em->persist($herbert);
//     $em->persist($orwell);
//     $em->persist($asimov);

//     $em->persist($sf);
//     $em->persist($dystopie);
//     $em->persist($classique);

//     $em->persist($dune);
//     $em->persist($book1984);
//     $em->persist($fondation);

//     // 5. Exécuter les requêtes SQL
//     $em->flush();

//     return new Response('✅ Données de test insérées avec succès !');
// }




#[Route('/livres', name: 'app_book_index')]
public function index(BookRepository $bookRepository): Response
{

$books = $bookRepository->findAll();

// $availableCount = count(array_filter($books, fn($book) => $book['available']));
    return $this->render('book/index.html.twig', [
        'books' => $books
    ]);
}    


  #[Route('/livre/{id}', name: 'app_book_show', requirements: ['id' => '\d+'])]
  public function show(BookRepository $bookRepository,int $id):Response
  {
   $book = $bookRepository->find($id);

                if(!$book)
                    {
                        throw $this->createNotFoundException("Le livre num $id est introuvable");
                    }

   return $this->render('book/show.html.twig',["book"=>$book]);
  }

// public function show(int $id): Response
// {
//     // Données simulées
//     $book = [
//         'id' => $id,
//         'title' => 'Livre n°' . $id,
//         'author' => 'Auteur inconnu',
//         'description' => 'Un livre passionnant de notre bibliothèque.',
//     ];

//     return $this->render('book/show.html.twig', [
//         'book' => $book,
//     ]);
// }

    #[route('/auteur/{name}',name:'app_author_show')]
    public function showAuthor(string $name):Response
    {
        return new Response("Page de l'auteur : $name");
    }

    #[route('/categorie/{categorie/{category}/livre/{id}',name :'app_book_by_category',requirements:['id'=>'\d+'])]
public function showByCategory(string $category , int $id):Response
{

return  new Response("vous avez choisi le livre [ $id ] de  la categorie : [$category ] : ");
}

    }
