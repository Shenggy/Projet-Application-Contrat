<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contactpage", name="contactpage")
     */
    public function contactpage(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('contact/contact.html.twig');
    }
}