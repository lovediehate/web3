<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Заголовок вопроса',
                'attr' => array(
                    'placeholder' => 'Введите заголовок'
                )
            ))
            ->add('content', TextType::class, array(
                'label' => 'Текст',
                'attr' => array(
                    'placeholder' => 'Введите текст',
                    'empty_data' => ''
                )
            ))
            ->add('category', EntityType::class, array(
                'label' => 'Категория',
                'class' => Category::class,
                'required' => true,
                //'attr' => array(
                    'choice_label' => 'title',
                    //'placeholder' => 'Введите текст'
                )//)
            )
            ->add('save', SubmitType::class, array(
                'label' => 'Сохранить'
            ))
            ->add('delete', SubmitType::class, array(
                'label' => 'Удалить'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'arg' =>null
        ]);
    }
}
