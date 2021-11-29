<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'required' => true,
            'constraints' => [
                new Email([
                    'message' => 'Email введен не корректно!',
                ]),
                new Length([
                    'max' => 180,
                ]),
            ],
            'label' => 'Email',
            'attr' => [
                'class' => 'validate',
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'label' => 'Пароль',
            'constraints' => [
                new NotBlank([
                    'message' => 'Пожалуйста, введите пароль',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Ваш пароль должен быть не менее {{ limit }} символов',
                    'max' => 4096,
                    'maxMessage' => 'Максимальное число символов - {{ limit }}',
                ]),
            ],
        ])
        ->add('save', SubmitType::class, array(
            'label' => 'Зарегистрировать'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
