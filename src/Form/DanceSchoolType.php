<?php

namespace App\Form;

use App\Entity\DanceCategory;
use App\Entity\DanceSchool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DanceSchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('localisation', TextType::class)
            ->add('openday', TextType::class)
            ->add('closeday', TextType::class)
            ->add('opentime', TextType::class)
            ->add('closetime', TextType::class)
            // Ajouter un champ pour sélectionner la DanceCategory
            ->add('danceCategory', EntityType::class, [
                'class' => DanceCategory::class,
                'choice_label' => 'name',  // Afficher le nom de la catégorie dans la liste déroulante
                'placeholder' => 'Choisissez une catégorie',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DanceSchool::class,
        ]);
    }
}
