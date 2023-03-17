<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
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

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'delete_label' => 'Supprimez la photo',
                'allow_delete' => true,
                

            ])

            ->add('receiptFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimez le ticket',
                'label' => 'Receipt',
                'data' => '',
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
            ])
            ->add('Ajoutez', SubmitType::class);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
