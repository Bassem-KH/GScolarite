<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialiteInscrit
 *
 * @ORM\Table(name="specialite_inscrit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialiteInscritRepository")
 */
class SpecialiteInscrit
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
     * @return SpecialiteInscrit
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
     * @ORM\OneToMany(targetEntity="CycleInscrit", mappedBy="specialiteinscrit")
     */
    private $cycleinscrit;

    public function __construct()
    {
        $this->cycleinscrit = new ArrayCollection();
    }

    public function getCycleInscrit()
    {
        return $this->cycleinscrit;
    }

    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="specialiteinscrit")
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
