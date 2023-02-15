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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MemorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => "Nom de l'animal",
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Inconnu' => 'Inconnu',
                    'Male' => 'Male',
                    'Femelle' => 'femelle',
                ],
            ])
            ->add('dateNaissance', DateType::class, [
                // Pour avoir un mini calendrier à l'affichage
                'widget' => 'single_text',
                'label' =>  'Date de naissance',
            ])
            ->add('dateDeces', DateType::class, [
                // Pour avoir un mini calendrier à l'affichage
                'widget' => 'single_text',
                'label' =>  'Date de décès',
            ])
            ->add('lieu')
            ->add('imgMemorial', FileType::class, [
                'label' => "Image de l'animal",
                // Signifie que ce champ n'est pas associé à une propriété de l'entité AnimalMemorial
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    /* On ne peut pas définir la validation des champs non mappés 
                    en utilisant des annontaions dans l'entité, On utilise donc les classes de contrainte php */
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un format valide (jpeg, jpg, png)',
                    ])
                ]
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Présentation',
            ])
            ->add('chosesAimees', TextareaType::class, [
                'label' => "Ce qu'il / elle aimait"
            ])
            ->add('chosesDetestees', TextareaType::class, [
                'label' => "Ce qu'il / elle détestait"
            ])
            ->add('histoire', TextareaType::class, [
                'label' => "Votre histoire / amitié"
            ])
            ->add('categorieAnimal', EntityType::class, [
                'label' => 'Categorie',
                'class' => CategorieAnimal::class,
            ])
            ->add('auteur')
            ->add('submit', SubmitType::class)
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
