<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cycle
 *
 * @ORM\Table(name="cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CycleRepository")
 */
class Cycle
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
     * @return Cycle
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
     * @ORM\ManyToOne(targetEntity="Specc", inversedBy="cycle")
     */
    private $specc;

    public function setSpecc(Specc $specc)
    {
        $this->specc = $specc;
    }

    public function getSpecc()
    {
        return $this->specc;
    }


    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="cycle")
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
