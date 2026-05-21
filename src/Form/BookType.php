<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Ex: Dune'],
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'required' => false,
                'attr' => ['rows'=> 5 ,'placeholder' => 'Résumé du livre...']
            ])
            ->add('stock',IntegerType::class,[
                'label'=>'Stock',
                'attr'=>['min',0],
            ])
            ->add('isbn',TextType::class,[
                'label'=>'isbn du livre'
            ])

            ->add('author', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => function (Auteur $author):string
                {
                    return $author->getFirstName().' '.$author->getLastName() ;
                },
                'label' => 'Auteur',
                'placeholder' => '--- Choisir un Auteur --- '
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded' => true,
                'labe'     => 'Catégories',
                'required' => 'false'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
