<?php

namespace Amenophis\Bundle\SocialBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Amenophis\Bundle\SocialBundle\Entity\Social as Entity;
use Amenophis\Bundle\SocialBundle\Exception as Exceptions;

class Social
{
    /** @var Doctrine\ORM\EntityManager */
    protected $em;

    /** @var Symfony\Component\Security\Core\SecurityContext */
    protected $context;

    public function __construct(EntityManager $em, SecurityContext $context)
    {
        $this->em = $em;
        $this->context = $context;
    }

    protected function getUser()
    {
        return $this->context->getToken()->getUser();
    }

    protected function verifyItem($item)
    {
        if(!$item)
        {
            throw new Exceptions\NullItemException('Item cannot be null');
        }

        $className = get_class($item);
        $repository = $this->em->getRepository($className);
        $loadedItem = $repository->find($item->getId());

        if(!$loadedItem)
        {
            throw new Exceptions\NotFoundException('Item not found');
        }
    }

    protected function getSocialItem($type, $item)
    {
        return $this->em->getRepository('AmenophisSocialBundle:Social')->findOneBy(array(
            'class_name' => get_class($item),
            'type' => $type,
            'item_id' => $item->getId()
        ));
    }

    public function add($type, $item)
    {
        $this->verifyItem($item);

        if($this->getSocialItem($type, $item)){
            throw new Exceptions\AlreadySetException('Already Set');
        }

        $entity = new Entity();
        $entity->setItemId($item->getId());
        $entity->setType($type);
        $entity->setClassName(get_class($item));
        $entity->setUserId($this->getUser()->getId());

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function remove($type, $item)
    {
        $this->verifyItem($item);

        $entity = $this->getSocialItem($type, $item);

        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
        }
    }

    public function count($type, $className)
    {
        $items = $this->em->getRepository('AmenophisSocialBundle:Social')->findBy(array(
            'class_name' => $className,
            'type' => $type
        ));

        return count($items);
    }
}