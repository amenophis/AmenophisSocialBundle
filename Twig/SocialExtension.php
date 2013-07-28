<?php

namespace Amenophis\Bundle\SocialBundle\Twig;

use Amenophis\Bundle\SocialBundle\Service\SocialManager;

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

    public function getName()
    {
        return 'amenophis_social_extension';
    }
}