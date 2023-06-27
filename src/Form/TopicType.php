<?php

namespace App\Form;

use App\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du sujet * (maximum 255 caractères)',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le titre ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 255, 'minMessage' => 'Le titre doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le titre ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('firstComment', CKEditorType::class, [
                'label' => "Exprimez-vous *",
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le commentaire ne peut pas être nul']),
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
            'data_class' => Topic::class,
        ]);
    }
}
