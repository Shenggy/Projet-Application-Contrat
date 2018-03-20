<?php
namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Contrat;
use AppBundle\Form\ContratType;
use AppBundle\Entity\Service;

use AppBundle\Entity\Client;
use DoctrineTest\InstantiatorTestAsset\SerializableArrayObjectAsset;
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
            $file = $contrat->getUrl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->container->getParameter('contrat_directory'),
                $fileName);
            $contrat->setUrl($fileName);
            $idUser = $this->getUser();
            $contrat -> setNumService($idUser);
            $contrat -> setNumContratParent($contrat);
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
       // $securityContext = $this->container->get('security.authorization_checker');
        //if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $entityManager = $this->getDoctrine()->getManager();
            // TODO connexion pour récuperer user
            $user = $this->getUser();
            $userId = $user->getId();
            $typeUser = $entityManager->getMetadataFactory()->getMetadataFor(get_class($user))->getName();

            if($typeUser=='AppBundle\Entity\Service'){
                $type='Service';
                $contrats = $entityManager->getRepository(Contrat::class)->findAllContrat($userId,$type);
                return $this->render('contrat/listContrat.html.twig', array('typeUser' => $type,'contrats' => $contrats));
                //SELECT `id`,`intitule`,`url`,max(`dateCreation`),`type`,`client_id`,`service_id`,`contrat_id` FROM contrat GROUP by `contrat_id`
            }else if ($typeUser=='AppBundle\Entity\Client'){
                $type='Client';
               // $contrats = $entityManager->getRepository(Contrat::class)->findBy(["numClient"=>$userId]);
                $contrats = $entityManager->getRepository(Contrat::class)->findAllContrat($userId,$type);
                return $this->render('contrat/listContrat.html.twig',  array('typeUser' => $type,'contrats' => $contrats));
            }
       // }
        //else{
        //    return $this->render('Security/login_content.html.twig');
        //}
    }

    /**
     * @Route("/historique/{contratID}", name="getHistory")
     *
     * @ParamConverter("contrat", options={"mapping": {"contratID" : "id"}})
     */

    public function getHistory(Contrat $contratID) {
        $contrats = $this->getDoctrine()
            ->getRepository('AppBundle:Contrat')->findBy([
                "numContratParent" => $contratID
            ]);
        return $this->render("contrat/historiqueContrat.html.twig", array('contrats' => $contrats, 'contratHisto'=> $contratID));
    }


    /**
     * @Route("/Modification/{contratID}", name="updateContrat")
     *
     * @ParamConverter("contrat", options={"mapping": {"contratID" : "id"}})
     */

    public function updateContrat(Request $request,Contrat $contratID) {
        $contratModif = $this->getDoctrine()
            ->getRepository('AppBundle:Contrat')->findOneBy([
                "id" => $contratID
            ]);
        $contrat = new Contrat();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ContratType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contrat = $form->getData();
            $parent = $contratModif->getNumContratParent();
            $client = $contratModif-> getNumClient();
            // TODO récupérer le id du client via nom et prénom
            $file = $contrat->getUrl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->container->getParameter('contrat_directory'),
                $fileName);
            $contrat->setUrl($fileName);
            $idUser = $this->getUser();
            $contrat -> setNumService($idUser);
            $contrat -> setNumContratParent($parent);
            $contrat -> setNumClient($client);
            //TODO GERER ERREUR SI USER PAS CO
            $em->persist($contrat);
            $em->flush();
            return $this->redirectToRoute('findAllContrat');
        }
        $formView = $form->createView(); //On crée la vue
        return $this->render('contrat/modifyContrat.html.twig', array('form'=>$formView,'contrat'=>$contratModif)); //On l'affiche

    }



}