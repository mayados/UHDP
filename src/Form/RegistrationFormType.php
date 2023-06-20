<?php

namespace App\Form;

use Assert\Regex;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email(['message' => 'L\'email {{ value }} n\'est pas un email valide']),
                    new Assert\NotBlank(['message' => 'L\'email ne peut pas être vide']),
                ]
            ])
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le pseudo ne peut pas être nul']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le pseudo doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le pseudo ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'ai lu et j'accepte les conditions générales d'utilisation et la politique de confidentialité du site",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales du site',
                    ]),
                ],
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
                    'label' => 'Mot de passe (Au minimum 12 caractères dont une majuscule, une minuscule, un chiffre, un caractère spécial)',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner un mot de passe',
                        ]),
                        new Length([
                            'min' => 12,
                            'minMessage' => 'Votre mot de passe doit faire un minimum {{ limit }} caractères',
                            'max' => 50,
                        ]),
                        new Assert\Regex(pattern:"/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/", message:"Le mot de passe doit inclure au moins une majusule, une minscule, un chiffre et un caractère spécial.")
                    ],                    
                ],
                'second_options' => ['label' => 'Répéter le mot de passe'],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
