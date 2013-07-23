AmenophisSocialBundle
=====================

<?php
$item = $this->getDoctrine()->getManager()->getRepository('MyBundle:MyEntity')->find(4);

$service = $this->get('amenophis.social');

//Add
$service->add('like', $item);

//Remove
$service->remove('like', $item);

//Count
$count = $service->count('like', get_class($item));
