<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtudiantRepository")
 */
class Etudiant
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
     * @return Etudiant
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
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="etudiant")
     */
    private $classe;

    public function setClasse(Classe $classe)
    {
        $this->classe = $classe;
    }

    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="etudiant")
     */
    private $cursus;

    public function setCursus(Cursus $cursus)
    {
        $this->cursus = $cursus;
    }

    public function getCursus()
    {
        return $this->cursus;
    }


    /**
     * @ORM\OneToMany(targetEntity="Assiduite", mappedBy="etudiant")
     */
    private $assiduite;

    public function __construct()
    {
        $this->assiduite = new ArrayCollection();
    }

    public function getAssiduite()
    {
        return $this->assiduite;
    }
    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="etudiant")
     */
    private $evaluation;

    public function __construct2()
    {
        $this->evaluation = new ArrayCollection();
    }

    public function getEvaluation()
    {
        return $this->evaluation;
    }
}
