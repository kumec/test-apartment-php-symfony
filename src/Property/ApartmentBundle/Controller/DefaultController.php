<?php

namespace Property\ApartmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PropertyApartmentBundle:Default:index.html.twig');
    }
}
