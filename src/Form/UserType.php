<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le pseudo ne peut pas être nul']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le pseudo doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le pseudo ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('photoProfil', FileType::class, [
                'label' => "Image de profil",
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
                        'maxSize' => '300k',
                        'maxSizeMessage' => "Image trop lourde, veuillez en sélectionner une autre.",
                    ])
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
