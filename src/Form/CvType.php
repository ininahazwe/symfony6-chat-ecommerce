<?php

namespace App\Form;

use App\Entity\Cv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

                ->add('document', FileType::class, [
                        'label' => 'Brochure (PDF file)',
                        'mapped' => false,
                        'required' => false,
                        /*'constraints' => [
                                new File([
                                        'maxSize' => '1024k',
                                        'mimeTypes' => [
                                                'application/pdf',
                                                'application/x-pdf',
                                        ],
                                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                                ])
                        ],*/
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cv::class,
        ]);
    }
}
