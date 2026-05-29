<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Book;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Field\AuteurAutocompleteField;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Ex: Dune','size'=> 60,'style'=>'padding:8px;'],
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'required' => false,
                'attr' => ['rows'=> 10 ,'cols'=> 60,'placeholder' => 'Résumé du livre...']
            ])
            ->add('stock',IntegerType::class,[
                'label'=>'Stock',
                'attr'=>['min' => 0,'class'=>'ma-class-test','style'=>'padding:8px']
            ])

            // ->add('isbn',TextType::class,[
            //     'label'=>'Code isbn du livre',
            // ])
            ->add('isbn', TextType::class, [
                 'label'    => 'ISBN',
                'required' => false,
                'attr'     => ['placeholder' => 'Ex: 9782070360024'],
                                        ])
            // ->add('author', EntityType::class, [
            //     'class' => Auteur::class,
            //     'choice_label' => function (Auteur $author):string
            //     {
            //         return $author->getFirstName().' '.$author->getLastName() ;
            //     },
            //     'label' => 'Auteur',
            //     'placeholder' => '--- Choisir un Auteur --- '
            // ])
                 ->add('author',AuteurAutocompleteField::class, [
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
                'choice_label' => function(Category $category):string{
                    return $category->getName();
                },
                // 'choice_label' => 'id',
                'multiple' => true,
                'expanded' => true,
                'label'     => 'Catégories',
                'required' => 'false'
            ])
            // ->add('Envoyer',SubmitType::class,
            // [
            //     'label'=>'Enregistrer le livre',
            //     'attr'=>[ 'style' => 'padding:8px ; background:#00F; color:#FFF;']
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
