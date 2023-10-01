<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email');
        if ($options["password"]) {
            $builder
                ->add('password');
        }
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('profilePicture')
            ->add('sector', ChoiceType::class, [
                "choices" => User::POSSIBLE_SECTORS
            ])
            ->add('contractType', ChoiceType::class, [
                "attr" => [
                    'placeholder' => false,
                    "onChange" => "((a)=>{
                                    dateField = document.querySelector('#user_contractExpirationDate')
                                    if(a.value === 'CDI'){
                                        dateField.value = null;
                                        dateField.parentNode.style.display ='none'
                                    }else {
                                        dateField.parentNode.style.display ='block'
                                    }})(this)",
                ],
                "choices" => User::POSSIBLE_CONTRACT_TYPES
            ])
            ->add('contractExpirationDate', DateType::class, [
                "widget" => "single_text",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'password' => true
        ]);
        $resolver->setAllowedTypes('password', 'bool');
    }
}
