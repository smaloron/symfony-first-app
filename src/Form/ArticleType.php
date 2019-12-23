<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Form\DataTransformer\TagCollectionToStringDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File as AssertFile;

class ArticleType extends AbstractType
{
    /**
     * @var TagCollectionToStringDataTransformer
     */
    private $tagTransformer;

    /**
     * ArticleType constructor.
     * @param TagCollectionToStringDataTransformer $tagTransformer
     */
    public function __construct(TagCollectionToStringDataTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'titre'])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text'

            ])
            ->add('articleText', TextareaType::class,
                [   'label'=>'Texte',
                    'attr'=> ['rows'=>'15']
                ])
            /*
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'fullName',
                'multiple' => false,
                'expanded' => false
            ])
            */
            ->add('tags', TextType::class, ['label' => 'Liste des tags'])

            ->add('photoInput', FileType::class, [
                'label' => 'Télécharger le photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new AssertFile([
                        'maxSize'=> '1024k',
                        'mimeTypes' => [
                            'image/png', 'image/jpeg', 'image/gif'
                        ],
                        'maxSizeMessage' => 'Vous devez choisir un fichier de 5 Mo maximum',
                        'mimeTypesMessage' => 'Seuls les fichier image web sont autorisés'
                    ])
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;

        $builder->get('tags')->addModelTransformer($this->tagTransformer);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
