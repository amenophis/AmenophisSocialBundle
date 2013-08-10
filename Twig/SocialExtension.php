<?php

namespace Amenophis\Bundle\SocialBundle\Twig;

use Amenophis\Bundle\SocialBundle\Manager\SocialManager;

class SocialExtension extends \Twig_Extension
{
    public function __construct(SocialManager $service)
    {
        $this->service = $service;
    }

    public function getFunctions()
    {
        return array(
            'social_is' => new \Twig_Function_Method($this, 'social_is'),
            'social_count' => new \Twig_Function_Method($this, 'social_count'),
            'social_related' => new \Twig_Function_Method($this, 'social_related'),
            'social_related_owner' => new \Twig_Function_Method($this, 'social_related_owner'),
        );
    }

    public function social_is($type, $item)
    {
        return $this->service->is($type, $item);
    }

    public function social_count($type, $item)
    {
        return $this->service->count($type, $item);
    }

    public function social_related($type, $item)
    {
        return $this->service->related($type, $item);
    }

     public function social_related_owner($social_item)
    {
        return $this->service->related_owner($social_item);
    }

    public function getName()
    {
        return 'amenophis_social_extension';
    }
}