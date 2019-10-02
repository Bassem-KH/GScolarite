<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CycleInscrit
 *
 * @ORM\Table(name="cycle_inscrit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CycleInscritRepository")
 */
class CycleInscrit
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
     * @return CycleInscrit
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
     * @ORM\ManyToOne(targetEntity="SpecialiteInscrit", inversedBy="cycleinscrit")
     */
    private $specialiteinscrit;

    public function setSpecialiteInscrit(SpecialiteInscrit $specialiteinscrit)
    {
        $this->specialiteinscrit = $specialiteinscrit;
    }

    public function getSpecialiteInscrit()
    {
        return $this->specialiteinscrit;
    }


    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="cycleinscrit")
     */
    private $inscription;

    public function __construct()
    {
        $this->inscription = new ArrayCollection();
    }

    public function getInscription()
    {
        return $this->inscription;
    }
}
