<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class Product1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Donnez un nom à votre produit']
            ])
            ->add('imageFile', VichImageType::class)

            ->add('receipts', CollectionType::class, [
                'entry_type' => ReceiptType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])

            ->add('purchase_Date', DateType::class, [
                'years' => range(2000, date('Y')),
                'format' => 'dd MMMM yyyy',
                'data' => new \DateTime()
            ])
            ->add('warrantyDuration', IntegerType::class, [
                'label' => 'Indiquez la durée de la garantie ( en année(s) )',
                'attr' => [
                    'min' => 0,
                ],
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
