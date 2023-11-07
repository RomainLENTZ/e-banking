<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Virement;
use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', IntegerType::class,[
                'label' => 'Je fais un virement de',
                'required' => true,
            ])
            ->add('utilisateurBeneficiaire', EntityType::class, [
                'class' => User::class,
                'mapped' => false,
                'choice_label' => function ($user) {
                    return $user->getNom() . ' ' . $user->getPrenom();
                },
                'query_builder' => function (UserRepository $userRepository): QueryBuilder {
                    return $userRepository->createQueryBuilder('u')
                        ->orderBy('u.email', 'ASC');
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Faire le virement',
                'attr' => ['class' => 'btn-blue']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Virement::class,
        ]);
    }
}
