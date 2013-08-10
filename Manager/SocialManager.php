<?php

namespace Amenophis\Bundle\SocialBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use FOS\UserBundle\Model\UserManagerInterface;
use Amenophis\Bundle\SocialBundle\Event\SocialEvent;

use Amenophis\Bundle\SocialBundle\Exception as Exceptions;

class SocialManager
{
    const EVENT_ADD    = 'amenophis_social_add';
    const EVENT_REMOVE = 'amenophis_social_remove';

    /** @var Doctrine\ORM\EntityManager */
    protected $em;

    /** @var Symfony\Component\Security\Core\SecurityContext */
    protected $context;

    /** @var Symfony\Component\EventDispatcher\EventDispatcher */
    protected $dispatcher;

    /** @var FOS\UserBundle\Model\UserManagerInterface */
    protected $user_manager;

    protected $class;

    public function __construct(EntityManager $em, SecurityContext $context, EventDispatcher $dispatcher, UserManagerInterface $user_manager, $class)
    {
        $this->em = $em;
        $this->context = $context;
        $this->dispatcher = $dispatcher;
        $this->user_manager = $user_manager;
        $this->class = $class;
    }

    protected function getRepository()
    {
        return $this->em->getRepository($this->class);
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
        return $this->getRepository()->findOneBy([
            'class_name' => get_class($item),
            'type' => $type,
            'item_id' => $item->getId(),
            'user_id' => $this->getUser()->getId()
        ]);
    }

    public function is($type, $item)
    {
        return $this->getSocialItem($type, $item) !== null;
    }

    public function add($type, $item)
    {
        $this->verifyItem($item);

        if($this->getSocialItem($type, $item)){
            throw new Exceptions\AlreadySetException('Already Set');
        }

        $entity = new $this->class();
        $entity->setItemId($item->getId());
        $entity->setType($type);
        $entity->setClassName(get_class($item));
        $entity->setUserId($this->getUser()->getId());

        $this->em->persist($entity);
        $this->em->flush();

        $event = new SocialEvent($entity, SocialEvent::TYPE_ADD);
        $this->dispatcher->dispatch(self::EVENT_ADD, $event);
        $this->dispatcher->dispatch(self::EVENT_ADD.'_'.$type, $event);
    }

    public function remove($type, $item)
    {
        $this->verifyItem($item);

        $entity = $this->getSocialItem($type, $item);

        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
            $event = new SocialEvent($entity, SocialEvent::TYPE_REMOVE);
            $this->dispatcher->dispatch(self::EVENT_REMOVE, $event);
            $this->dispatcher->dispatch(self::EVENT_REMOVE.'_'.$type, $event);
        }
    }

    public function count($type, $item)
    {
        return count($this->related($type, $item));
    }

    public function related($type, $item)
    {
        return $this->getRepository()->findBy([
            'class_name' => get_class($item),
            'type' => $type,
            'item_id' => $item->getId()
        ]);
    }

    public function related_owner($social_item)
    {
        return $this->user_manager->findUserBy(['id' => $social_item->getUserId()]);
    }
}
