<?php

namespace Amenophis\Bundle\SocialBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Amenophis\Bundle\SocialBundle\Model\Social;

class SocialEvent extends Event
{
    const TYPE_ADD    = 'add';
    const TYPE_REMOVE = 'remove';

    /** @var Amenophis\Bundle\SocialBundle\Model\Social */
    private $item;

    /** @var string */
    private $type;

    public function __construct(Social $item, $type)
    {
        $this->item = $item;
        $this->type = $type;
    }

    /**
     * @return Amenophis\Bundle\SocialBundle\Model\Social
     */
    public function getItem()
    {
        return $this->item;
    }

    public function getType() {
        return $this->type;
    }
}
