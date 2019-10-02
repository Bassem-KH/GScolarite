<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Specc
 *
 * @ORM\Table(name="specc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpeccRepository")
 */
class Specc
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Specc
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * @ORM\OneToMany(targetEntity="Cycle", mappedBy="specc")
     */
    private $cycle;

    public function __construct()
    {
        $this->cycle = new ArrayCollection();
    }

    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="specc")
     */
    private $inscription;

    public function __construct2()
    {
        $this->inscription = new ArrayCollection();
    }

    public function getInscription()
    {
        return $this->inscription;
    }
}
