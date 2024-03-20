<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre email'
                ]
            ])
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
            ->add('birthdate', BirthdayType::class)
            ->add('address', TextType::class)
            ->add('phone_number', TelType::class)
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('submit_button', SubmitType::class, [
                'label' => "S'enregistrer",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
