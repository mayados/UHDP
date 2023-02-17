<?php

namespace App\Form;

use App\Entity\BelleHistoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HistoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                'label' => "Titre",
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le titre ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 255, 'minMessage' => 'Le nom titre faire au moins {{ limit }} caractères', 'maxMessage' => 'Le titre ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('texte', TextareaType::class, [
                'label' => 'Texte',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La présentation ne peut pas être nulle']),
                ]
            ])
            ->add('imgHistoire', FileType::class, [
                'label' => "Image de l'histoire",
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
            ->add('auteur')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BelleHistoire::class,
        ]);
    }
}
