<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */

    private $numClient;




    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     */

    private $numService;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="date")
     */
    private $dateCreation;

    public function __construct() {
        $this->dateCreation = new \DateTime();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Contrat")
     * @ORM\JoinColumn(name="contrat_id", referencedColumnName="id")
     */
    private $numContratParent;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numClient
     *
     * @param integer $numClient
     *
     * @return Contrat
     */
    public function setNumClient($numClient)
    {
        $this->numClient = $numClient;

        return $this;
    }

    /**
     * Get numClient
     *
     * @return int
     */
    public function getNumClient()
    {
        return $this->numClient;
    }

    /**
     * Set numService
     *
     * @param integer $numService
     *
     * @return Contrat
     */
    public function setNumService($numService)
    {
        $this->numService = $numService;

        return $this;
    }

    /**
     * Get numService
     *
     * @return int
     */
    public function getNumService()
    {
        return $this->numService;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Contrat
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }



    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Contrat
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Contrat
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Contrat
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set numContratParent
     *
     * @param integer $numContratParent
     *
     * @return Contrat
     */
    public function setNumContratParent($numContratParent)
    {
        $this->numContratParent = $numContratParent;

        return $this;
    }

    /**
     * Get numContratParent
     *
     * @return int
     */
    public function getNumContratParent()
    {
        return $this->numContratParent;
    }
}

