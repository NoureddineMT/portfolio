<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre prénom'
                ],
                'label_attr' => ['class' => 'text-darkgrey'],
                'row_attr' => ['class' => 'form-group col-md-6 mt-2'],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre prénom'
                ],
                'label_attr' => ['class' => 'text-darkgrey'],
                'row_attr' => ['class' => 'form-group col-md-6 mt-2'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre email'
                ],
                'label_attr' => ['class' => 'text-darkgrey'],
                'row_attr' => ['class' => 'form-group col-md-6 mt-2'],
            ])
            ->add('object', ChoiceType::class, [
                'label' => 'Sélectionnez un motif',
                'choices' => [
                    'Veuillez choisir une valeur par défaut' => NULL,
                    'Demande de collaboration' => 'Demande de collaboration',
                    "Offre d'emploi" => "Offre d'emploi",
                    "Demande d'information" => "Demande d'information",
                ],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'text-dark'];
                },
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => ['class' => 'text-darkgrey'],
                'row_attr' => ['class' => 'form-group col-md-6 mt-2'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre message'
                ],
                'label_attr' => ['class' => 'text-darkgrey'],
                'row_attr' => ['class' => 'form-group mt-2'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Nous contacter',
                'attr' => [
                    'class' => 'btn btn-purple mt-2',
                ],
                'row_attr' => [
                    'class' => 'form-group d-flex justify-content-center mt-3', 
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

