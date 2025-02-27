<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\DanceSchool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('contenu')
            ->add('instructor')
            ->add('danceSchool', EntityType::class, [
                'class' => DanceSchool::class,
                'choice_label' => 'name', // Affiche le nom de l'école de danse
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
