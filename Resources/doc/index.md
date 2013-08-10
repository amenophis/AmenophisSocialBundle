Getting Started With AmenophisSocialBundle
==================================

## Prerequisites

This version of the bundle requires Symfony 2.1+.

## Installation

Installation process in 5 steps:

1. Download AmenophisSocialBundle using composer
2. Enable the Bundle
3. Create your Social class
4. Configure the AmenophisSocialBundle
5. Update your database schema

### Step 1: Download AmenophisSocialBundle using composer

Add AmenophisSocialBundle in your composer.json:

```js
{
    "require": {
        "amenophis/social-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update amenophis/social-bundle
```

Composer will install the bundle to your project's `vendor/amenophis` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Amenophis\Bundle\SocialBundle\AmenophisSocialBundle(),
    );
}
```

### Step 3: Create your Social class

#### a) Doctrine ORM Social class

If you're persisting social data via the Doctrine ORM, then your `Social` class
should live in the `Entity` namespace of your bundle and look like this to
start:

##### Annotations

``` php
<?php

namespace Acme\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Amenophis\Bundle\SocialBundle\Model\Social as BaseSocial;

/**
 * Social
 *
 * @ORM\Table(name="acme_social",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="unique_by_type",
 *             columns={"class_name", "type", "item_id", "user_id"}
 *         )
 *     }
 * )
 * @ORM\Entity()
 * @UniqueEntity(fields={"class_name", "type", "item_id", "user_id"}, message="amenophis.social.unique")
 */
class Social extends BaseSocial
{
    // ...
}
```

### Step 4: Configure the AmenophisSocialBundle

Add the following configuration to your `config.yml` file.

``` yaml
# app/config/config.yml
amenophis_social:
    classes:
        social:
            entity: Acme\Bundle\CoreBundle\Entity\Social
```

### Step 5: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity, the `Social` class which you
created in Step 3.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

All is now OK to start using the bundle !

### Next Steps

The following documents are available:

- [Usage](usage.md)
- [Events](events.md)
