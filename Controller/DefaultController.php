<?php

namespace Amenophis\Bundle\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/social/{action}")
     * @Template()
     */
    public function indexAction($action = 'add')
    {
        $hosting = $this->getDoctrine()->getManager()->getRepository('RezooCoreBundle:Hosting')->find(4);

        $service = $this->get('amenophis.social');
        if($action == 'add') {
            $service->add('like', $hosting);
        } else if($action == 'remove') {
            $service->remove('like', $hosting);
        } else if($action == 'count'){
            echo $service->count('like', 'Rezoo\Bundle\RezooCoreBundle\Entity\Hosting');
            die();
        }

        return array();
    }
}
