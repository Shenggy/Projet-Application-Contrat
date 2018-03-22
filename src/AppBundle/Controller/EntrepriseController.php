<?php

namespace AppBundle\Controller;

use AppBundle\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\AppBundle;

use DoctrineTest\InstantiatorTestAsset\SerializableArrayObjectAsset;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class EntrepriseController extends Controller
{
    /**
     * @Route("/ajoutEntreprise", name="addEntreprise")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addEntreprise( Request $request) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EntrepriseType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entreprise = $form->getData();
            // TODO récupérer le id du client via nom et prénom
            $em->persist($entreprise);
            $em->flush();
            return $this->redirectToRoute('service_registration');
        }
        $formView = $form->createView(); //On crée la vue
        return $this->render('entreprise/addEntreprise.html.twig', array('form'=>$formView)); //On l'affiche
    }
}