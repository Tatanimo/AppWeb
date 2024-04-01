<?php

namespace App\Form;

use App\Entity\Users;
use App\Validator\BirthdateAdult;
use App\Validator\BirthdateMax;
use App\Validator\BirthdateMin;
use App\Validator\EmailConcordance;
use App\Validator\PhoneInternationalFormat;
use App\Validator\SolidPassword;
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
use Symfony\Component\Validator\Constraints\NotNull;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $max = date_create();
        date_sub($max,date_interval_create_from_date_string("18 years"));
        $min = date_create();
        date_sub($min,date_interval_create_from_date_string("99 years"));
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre email'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un email"
                    ]),
                    new EmailConcordance([
                        'message' => "Cet email est déjà utilisé, veuillez choisir un autre."
                    ])
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
                        new SolidPassword()
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation de mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir confirmer votre mot de passe',
                    ]
                ],
            ])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'max' => date_format($max, 'Y-m-d'),
                    'min' => date_format($min, 'Y-m-d')
                ],
                'constraints' => [
                    new NotNull(),
                    new NotBlank(),
                    new BirthdateMax(),
                    new BirthdateMin()
                ]
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new NotBlank(),
                ]
            ])
            ->add('phone_number', TelType::class, [
                'constraints' => [
                    new PhoneInternationalFormat(),
                ],
                'required' => false
            ])
            ->add('first_name', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le prénom doit contenir au minimum 3 caractères',
                        'max' => 50,
                        'minMessage' => 'Le prénom doit contenir au maximum 50 caractères',
                    ])
                ]
            ])
            ->add('last_name', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom de famille doit contenir au minimum 3 caractères',
                        'max' => 100,
                        'minMessage' => 'Le nom de famille doit contenir au maximum 100 caractères',
                    ])
                ]
            ])
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
