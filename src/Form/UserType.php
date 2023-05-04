<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                'disabled' => true,
                // 'constraints' => [
                //     new Email(['message' => 'L\'email {{ value }} n\'est pas un email valide']),
                //     // new Assert\NotBlank(['message' => 'L\'email ne peut pas être vide']),
                // ]
            ])
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le pseudo ne peut pas être nul']),
                    new Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le pseudo doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le pseudo ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])            
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_MODERATEUR_HISTOIRES' => 'ROLE_MODERATEUR_HISTOIRES',
                    'ROLE_MODERATEUR_FORUM' => 'ROLE_MODERATEUR_FORUM',
                    'ROLE_MODERATEUR_MEMORIAUX' => 'ROLE_MODERATEUR_MEMORIAUX',
                    'ROLE_MODERATEUR_COMMEMORATION' => 'ROLE_MODERATEUR_COMMEMORATION',
                ],
                // La contrainte ne fonctionne pas car il faut donner chaque élément sous forme de tableau
                // 'constraints' => [
                //     new Assert\Choice(['choices' => ['ROLE_USER','ROLE_MODERATEUR_HISTOIRES','ROLE_MODERATEUR_FORUM','ROLE_MODERATEUR_MEMORIAUX','ROLE_MODERATEUR_COMMEMORATION'], 'message' => 'Veuillez choisir un rôle valide']),                    
                // ],
                'label' => 'Rôle',
            ])
            // ->add('photoProfil', FileType::class, [
            //     'label' => "Image de profil",
            //     // Signifie que ce champ n'est pas associé à une propriété de l'entité AnimalMemorial
            //     'mapped' => false,
            //     'required' => false,
            //     'constraints' => [
            //         /* On ne peut pas définir la validation des champs non mappés 
            //         en utilisant des annontaions dans l'entité, On utilise donc les classes de contrainte php */
            //         new File([
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/png',
            //             ],
            //             'mimeTypesMessage' => 'Veuillez choisir un format valide (jpeg, jpg, png)',
            //             'maxSize' => '300k',
            //             'maxSizeMessage' => "Image trop lourde, veuillez en sélectionner une autre.",
            //         ])
            //     ]
            // ])
            ->add('submit', SubmitType::class)
        ;
            // Ici nous devons ajouter un dataTransformer car la propriété roles de l'entité User est un tableau, alors que dans le ChoiceType c'est considéré comme une string
        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                // transform the array to a string
                return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
                // transform the string back to an array
                return [$rolesString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
