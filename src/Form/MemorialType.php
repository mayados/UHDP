<?php

namespace App\Form;

use App\Entity\AnimalMemorial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MemorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('sexe')
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
            ->add('presentation')
            ->add('chosesAimees')
            ->add('chosesDetestees')
            ->add('histoire')
            ->add('categorieAnimal')
            ->add('auteur')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalMemorial::class,
        ]);
    }
}
