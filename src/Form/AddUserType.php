<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email(['message' => 'L\'email {{ value }} n\'est pas un email valide']),
                    new Assert\NotBlank(['message' => 'L\'email ne peut pas être vide']),
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
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Le mot de passe doit faire un minimum {{ limit }} caractères',
                            'max' => 50,
                        ]),
                    ],                    
                ],
                'second_options' => ['label' => 'Répéter le mot de passe'],

            ])
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le pseudo ne peut pas être nul']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le pseudo doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le pseudo ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            // ->add('bannir')
            // ->add('isVerified')
            // ->add('dateInscription')
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
