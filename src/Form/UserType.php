<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label_attr' => [
                    'for' => 'user_firstname',
                ],
                'attr' => [
                    'placeholder' => 'Enter your firstname',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label_attr' => [
                    'for' => 'user_lastname',
                ],
                'attr' => [
                    'placeholder' => 'Enter your lastname',
                ]
            ])
            ->add('pseudo', TextType::class, [
                'label_attr' => [
                    'for' => 'user_pseudo',
                ],
                'attr' => [
                    'placeholder' => 'Enter your pseudo',
                ]
            ])
            ->add('email', EmailType::class, [
                'label_attr' => [
                    'for' => 'user_email',
                ],
                'attr' => [
                    'placeholder' => 'Enter your email address',
                ],
            ])
            ->add('phonenumber', TextType::class, [
                'label_attr' => [
                    'for' => 'user_phonenumber',
                ],
                'attr' => [
                    'placeholder' => 'Enter your phonenumber',
                ],
            ])
            ->add('address', TextType::class, [
                'label_attr' => [
                    'for' => 'user_address',
                ],
                'attr' => [
                    'placeholder' => 'Enter your address',
                ],
            ])
            ->add('birthdate', DateType::class, [
                'label_attr' => [
                    'for' => 'user_birthdate',
                ],
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'Enter your birthdate',
                ],
                'years' => $this->getAvailableYears(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getAvailableYears(){
        $currentYear = new \DateTime();
        $currentYear = intval($currentYear->format('Y'));
        $yearArray = [];
        for($i=0; $i<100; $i++){
            $yearArray[$currentYear-$i] = $currentYear-$i;
        }

        return $yearArray;
    }

}
