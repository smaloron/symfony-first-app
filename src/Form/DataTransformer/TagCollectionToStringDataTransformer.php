<?php


namespace App\Form\DataTransformer;


use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagCollectionToStringDataTransformer implements DataTransformerInterface
{

    const SEPARATOR = ', ';

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * TagCollectionToStringDataTransformer constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }


    /**
     * @param ArrayCollection $tagCollection
     * @return mixed|void
     */
    public function transform($tagCollection) : string
    {
        $tagArray = $tagCollection->toArray();

        return implode(self::SEPARATOR, $tagArray);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($tagString)
    {
        if(empty($tagString)){
            return [];
        }

        $tagNameArray = array_unique(
            array_map(
                'trim',
                explode(self::SEPARATOR, $tagString)
            )
        );

        $tags = [];

        foreach ($tagNameArray as $tagName){

            $tag = $this->tagRepository->findOneBy(['tagName' =>$tagName]);

            if($tag == null){
                $tag = new Tag();
                $tag->setTagName($tagName);
            }

            array_push($tags, $tag);
        }

        return $tags;
    }
}