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
                // 'required' => false,
                'attr' => [
                'placeholder' => 'Rechercher un mémorial' ,               
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
            ->add('anneeDeces', ChoiceType::class, [
                'choices' => $this->buildYearChoices(),
                'placeholder' => '',
                'required' => false,
            ])
            ->add('moisDeces', ChoiceType::class, [
                'choices' => $this->buildMonthChoices(),
                'placeholder' => 'test',
                'required' => false,

            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function buildYearChoices() {
        $distance = 30;
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distance));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        return array_combine(range($yearsAfter, $yearsBefore), range($yearsAfter, $yearsBefore));
    }

    // public function buildMonthChoices() {
    //     $month = date('m', mktime(0, 0, 0, 1, 1, 2023));
    //     // dd($month);
    //     return array(range(date($month),12));
    // }

    public function buildMonthChoices() {
        $months = [
            'Janvier' => date('m', mktime(0, 0, 0, 1, 1, 2023)),
            'Février' => date('m', mktime(0, 0, 0, 2, 1, 2023)),
            'Mars' => date('m', mktime(0, 0, 0, 3, 1, 2023)),
            'Avril' => date('m', mktime(0, 0, 0, 4, 1, 2023)),
            'Mai' => date('m', mktime(0, 0, 0, 5, 1, 2023)),
            'Juin' => date('m', mktime(0, 0, 0, 6, 1, 2023)),
            'Juillet' => date('m', mktime(0, 0, 0, 7, 1, 2023)),
            'Aout' => date('m', mktime(0, 0, 0, 8, 1, 2023)),
            'Septembre' => date('m', mktime(0, 0, 0, 9, 1, 2023)),
            'Octobre' => date('m', mktime(0, 0, 0, 10, 1, 2023)),
            'Novembre' => date('m', mktime(0, 0, 0, 11, 1, 2023)),
            'Decembre' => date('m', mktime(0, 0, 0, 12, 1, 2023)),
        ];
        
        // A revoir, car avec mktime les valeurs attribuées aux mois mois vont changées au cours du temps, sauf avec valeur fixe ?

        // dd($months);
       return $months;
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
