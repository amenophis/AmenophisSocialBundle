AmenophisSocialBundle Usage
========================

You can find a real use case fo a 'like' functionality as facebook does.

``` php
<?php

namespace Acme\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\Bundle\CoreBundle\Entity\Publication;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="acme_homepage")
     * @Template()
     */
    public function homeAction()
    {
        return array(
            'publications' => $this->getDoctrine()->getManager()->getRepository('AcmeCoreBundle:Publication')->findAll()
        );
    }

    /**
     * @Route("/publication/{id}/like", name="acme_publication_like")
     */
    public function publicationLikeAction(Publication $publication)
    {
        if(!$this->get('amenophis.social')->is('like', $publication)){
            $this->get('amenophis.social')->add('like', $publication);
        }

        return $this->redirect($this->generateUrl('acme_homepage'));
    }

    /**
     * @Route("/publication/{id}/unlike", name="acme_publication_unlike")
     */
    public function publicationUnlikeAction(Publication $publication)
    {
        if($this->get('amenophis.social')->is('like', $publication)){
            $this->get('amenophis.social')->remove('like', $publication);
        }

        return $this->redirect($this->generateUrl('acme_homepage'));
    }
}
```