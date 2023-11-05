<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeDeCompte', ChoiceType::class,[
                'label' => 'Type de compte',
                'required' => true,
                'choices' => [
                    'Compte courant' => 'compte_courant',
                    'Compte épargne' => 'compte_epargne',
                    'Compte titre' => 'compte_titre',
                ]
            ])
            ->add('detenteur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'query_builder' => function (UserRepository $userRepository): QueryBuilder {
                    return $userRepository->createQueryBuilder('u')
                        ->orderBy('u.email', 'ASC');
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer le compte'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
