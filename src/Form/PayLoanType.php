<?php

namespace App\Form;

use App\Entity\Emprunt;
use PHPUnit\Framework\Constraint\GreaterThan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class PayLoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', NumberType::class,[
                'label' => 'Combien souhaitez vous rembourser ?',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new \Symfony\Component\Validator\Constraints\GreaterThan([
                        'value' => 0,
                        'message' => 'La valeur doit être supérieure à 0.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rembourser'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
