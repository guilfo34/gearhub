<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Posts;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{

    private $security;

public function __construct(Security $security)
    {
        $this->security = $security;

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $this->security->getUser();

        $builder
            ->add('car', EntityType::class, [
                'label' => 'Cars',
                'class' => Cars::class,
                'query_builder' => function (EntityRepository $er) use ($currentUser): QueryBuilder {
                    return $er->createQueryBuilder('Cars')
                        ->where('Cars.user = :currentUser')
                        ->setParameter('currentUser', $currentUser)
                        ->andWhere();
                },
                'choice_label' => 'brand'
            ])
            ->add('text', TextType::class)
            ->add('img', FileType::class, [
                'label' => false,
                'data_class' => null,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpg',
                            'image/webp',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => "Veuillez sélectionner le bon type de fichier"
                    ])
                ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
} 

