<?php

namespace App\Form;

use App\Entity\AnimalMemorial;
use App\Entity\CategorieAnimal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Image;

class MemorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => "Nom de l'animal *",
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le nom doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le nom ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => "Sexe de l'animal *",
                'choices' => [
                    'Male' => 'Male',
                    'Femelle' => 'Femelle',
                ],
                'constraints' => [
                    new Assert\Choice(['choices' => ['Inconnu','Male','Femelle'], 'message' => 'Veuillez choisir un genre valide']),                    
                ]

            ])
            ->add('dateNaissance', DateType::class, [
                // Pour avoir un mini calendrier à l'affichage
                'widget' => 'single_text',
                'required' => false,
                'label' =>  'Date de naissance',
                'constraints' => [
                     /* Il ne serait pas logique de pouvoir sélectionner une date supérieure à la date actuelle
                     On ajoute en contrainte que la date soumise doit être inférieure ou égale à la date acteulle (en fonction de la date du serveur) */
                    new Assert\LessThanOrEqual(['value' => 'today', 'message' => 'La date de naissance ne peut pas être supérieure à la date actuelle']),
                ]
            ])
            ->add('dateDeces', DateType::class, [
                // Pour avoir un mini calendrier à l'affichage
                'widget' => 'single_text',
                'label' =>  'Date de décès *',
                'required' => true,
                'constraints' => [
                    // Il ne serait pas logique de pouvoir sélectionner une date supérieure à la date actuelle
                    new Assert\NotBlank(['message' => 'La date de décès ne peut pas être vide']), 
                    new Assert\LessThanOrEqual(['value' => 'today', 'message' => 'La date de décès ne peut pas être supérieure à la date actuelle']),
                ]
            ])
            ->add('lieu', TextType::class, [
                'label' => "Lieu de vie de l'animal",
                'required' => false,
                // Certains navigateurs ont une autocomplétion de base, mais nous ne la voulons pas car nous en créons une 
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100, 'minMessage' => 'Le lieu doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le lieu ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('imgMemorial', FileType::class, [
                'label' => "Image de l'animal",
                // Signifie que ce champ n'est pas associé à une propriété de l'entité AnimalMemorial
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    /* On ne peut pas définir la validation des champs non mappés 
                    en utilisant des annontaions dans l'entité, On utilise donc les classes de contrainte php */
                    new Image([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un format valide (jpeg, jpg, png)',
                        'maxSize' => '500k',
                        'maxSizeMessage' => "Image trop lourde, veuillez en sélectionner une autre.",
                    ])
                ]
            ])
            ->add('presentation', CKEditorType::class, [
                'label' => "Présentation * (sa façon d'être, son comportement, ses habitudes...)",
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La présentation ne peut pas être nulle']),
                ]
            ])
            ->add('chosesAimees', CKEditorType::class, [
                'label' => "Ce qu'il / elle aimait *",
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Cette section ne peut pas être nulle']),
                ]
            ])
            ->add('chosesDetestees', CKEditorType::class, [
                'label' => "Ce qu'il / elle détestait *",
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Cette section ne peut pas être nulle']),
                ]
            ])
            ->add('histoire', CKEditorType::class, [
                'label' => "Votre histoire / amitié * (La façon dont vous vous êtes connus, pourquoi vous ne vous êtes jamais quittés..)",
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Cette section ne peut pas être nulle']),
                ]
            ])
            ->add('categorieAnimal', EntityType::class, [
                'label' => 'Categorie *',
                'class' => CategorieAnimal::class,
                'constraints' => [
                    new Assert\NotNull(['message' => 'La catégorie ne peut pas être nulle']),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalMemorial::class,
            'sanitize-html' => true,
        ]);
    }
}
