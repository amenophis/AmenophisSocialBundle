AmenophisSocialBundle Events
========================

You can hook after Add or Remove process by registering an event listener like the example below.
You will see that you can register in a generic way for all types (like, follow, ...) by tag those events: amenophis_social_add, amenophis_social_remove.

If you want to handle only one type, like for example, you need to tag the event as amenophis_social_add_like, amenophis_social_remove_like

### EventListener class

``` php
<?php

namespace Acme\Bundle\CoreBundle\EventListener;

use Amenophis\Bundle\SocialBundle\Event\SocialEvent;

class SocialEventListener
{
    public function onAdd(){
        echo "onAdd";
    }

    public function onRemove(){
        echo "onRemove";
    }

    public function onLike(){
        echo "onLike";
    }

    public function onUnlike(){
        echo "onUnlike";
    }
}
```

### EventListener registration

``` yaml
services:
    acme.listener.social.like:
        class:     Acme\Bundle\CoreBundle\EventListener\SocialEventListener
        arguments: []
        tags:
            - { name: kernel.event_listener, event: amenophis_social_add, method: onAdd }
            - { name: kernel.event_listener, event: amenophis_social_remove, method: onRemove  }
            - { name: kernel.event_listener, event: amenophis_social_add_like, method: onLike }
            - { name: kernel.event_listener, event: amenophis_social_remove_like, method: onUnlike  }
```