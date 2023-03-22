<?php

namespace App\Form;

use App\Entity\ProductDoc;
use App\Form\ProductDocType as FormProductDocType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CollecType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('docs', CollectionType::class, [
                'entry_type' => ProductDocType::class, 
                'label' => 'Photo(s) supplementaire(s)',
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => ProductDoc::class,
        ]);
    }
}
