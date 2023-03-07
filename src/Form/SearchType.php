<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\CategorieAnimal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'attr' => [
                'placeholder' => 'Rechercher un mémorial'                 
                ]
            ])
            ->add('categories', EntityType::class,[
                'label'=> false,
                'required' => false,
                'class' => CategorieAnimal::class,
                // Il faut mettre ce tag, car nous sommes dans le cas de checkboxes
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Inconnu' => 'Inconnu',
                    'Male' => 'Male',
                    'Femelle' => 'Femelle',
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('dateDeces', DateType::class, [
                // Pour avoir un mini calendrier à l'affichage
                'widget' => 'choice',
                'label' =>  'Date de décès',
                'format' => 'dd/MM/yyyy',
                'constraints' => [
                    // Il ne serait pas logique de pouvoir sélectionner une date supérieure à la date actuelle
                    new Assert\LessThanOrEqual(['value' => 'today', 'message' => 'La date de décès ne peut pas être supérieure à la date actuelle']),
                ]
            ])  
            // ->add('dateDeces', DateType::class, [
            //     'placeholder' => [
            //         'month' => 'Month', 'year' => 'Year',
            //     ],
            // ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Ici il ne s'agit pas d'une entité, mais d'une classe
            'data_class' => SearchData::class,
            'method' => 'GET',
            // Nous n'avons pas besoin d'un jetons CSRF car c'est du get
            'csrf_protection' => false,
        ]);
    }
}
