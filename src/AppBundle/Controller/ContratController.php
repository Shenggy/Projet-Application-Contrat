<?php
namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Contrat;
use AppBundle\Form\ContratType;
use AppBundle\Entity\Service;

use AppBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class ContratController extends Controller {


    /**
     * @Route("/addContrat", name="addContrat")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addContrat( Request $request) {
        $contrat = new Contrat();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ContratType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($form->isSubmitted() && $form->isValid()) {

            $contrat = $form->getData();
            // TODO récupérer le id du client via nom et prénom
            $nomUser=$form->get('nomUser')->getData();
            $prenomUser=$form->get('prenomUser')->getData();
            $file = $contrat->getUrl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->container->getParameter('contrat_directory'),
                $fileName);
            $contrat->setUrl($fileName);
            //$Client = $this->getDoctrine()->getManager()->getRepository(Client::class)->findBy([array("nom" => "Client", "prenom" => "test")],array('name' => 'ASC'),1 ,0);
            //$Client = $repository->findBy([array("nom" => $nomUser, "prenom" => $prenomUser)],array('name' => 'ASC'),1 ,0);
            //$Client = $repository->findBy([array("nom" => "Client", "prenom" => "test")],array('name' => 'ASC'),1 ,0);
            // pas sur du getId
            //$idClient = $Client->getId();
            $idClient = 3;
            //$contrat -> setNumService($user);
            $entityManager = $this->getDoctrine()->getManager();
            $Client = $entityManager->getRepository(\AppBundle\Entity\Client::class)->find(3);
            $Service = $entityManager->getRepository(Service::class)->find(1);
            $contrat -> setNumService($Service);
            $contrat -> setNumClient($Client);
            //TODO GERER ERREUR SI USER PAS CO
            $em->persist($contrat);
            $em->flush();
            return $this->redirectToRoute('findAllContrat');
        }
        $formView = $form->createView(); //On crée la vue
        return $this->render('contrat/addContrat.html.twig', array('form'=>$formView)); //On l'affiche
    }
    /**
     * @Route("/findAllContrat", name="findAllContrat")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function findAllContrat()
    {
        $entityManager = $this->getDoctrine()->getManager();
        // TODO connexion pour récuperer user
        //$userId = $this->getUser();
       // $userId->getId();
        $userId='1';
        $contrats = $entityManager->getRepository(Contrat::class)->findBy(["numService"=>$userId]);
        return $this->render('contrat/listContrat.html.twig', array('contrats' => $contrats));
    }

}