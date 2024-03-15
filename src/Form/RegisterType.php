<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe doit être identique',
                'required' => true,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe',
                    ]
                    ],
                'second_options' => [
                    'label' => 'Confirmation de mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir confirmer votre mot de passe',
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe"
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au minimum 8 caractères',
                        'max' => 255,
                        'maxMessage' => 'Votre mot de passe doit faire moins de 255 caractères',
                    ]),
                ]
            ])
            ->add('birthdate')
            ->add('adress')
            ->add('postal_code')
            ->add('city')
            ->add('phone_number')
            ->add('IBAN')
            ->add('image')
            ->add('first_name')
            ->add('last_name')
            ->add('submit_button', SubmitType::class, [
                'label' => "S'enregistrer",
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
