<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="classe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClasseRepository")
 */
class Classe
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
     * @var int
     *
     * @ORM\Column(name="nbrEtudiants", type="integer")
     */
    private $nbrEtudiants;


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
     * @return Classe
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
     * Set nbrEtudiants.
     *
     * @param int $nbrEtudiants
     *
     * @return Classe
     */
    public function setNbrEtudiants($nbrEtudiants)
    {
        $this->nbrEtudiants = $nbrEtudiants;

        return $this;
    }

    /**
     * Get nbrEtudiants.
     *
     * @return int
     */
    public function getNbrEtudiants()
    {
        return $this->nbrEtudiants;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="classe")
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
     * @ORM\OneToMany(targetEntity="Etudiant", mappedBy="classe")
     */
    private $etudiant;

    public function __construct()
    {
        $this->etudiant = new ArrayCollection();
    }

    public function getEtudiant()
    {
        return $this->etudiant;
    }
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Enseignant", inversedBy="classe")
     */
    protected $enseignants;

    /**
     * @return ArrayCollection
     */
    public function getEnseignants()
    {
        return $this->enseignants;
    }

    /**
     * @param ArrayCollection $enseignants
     */
    public function setEnseignants($enseignants)
    {
        $this->enseignants = $enseignants;
    }

    public function __construct2()
    {
        $this->enseignants= new ArrayCollection();
    }
    /**
     * @ORM\OneToMany(targetEntity="Assiduite", mappedBy="classe")
     */
    private $assiduite;

    public function __construct3()
    {
        $this->assiduite = new ArrayCollection();
    }

    public function getAssiduite()
    {
        return $this->assiduite;
    }
    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="classe")
     */
    private $evaluation;

    public function __construct4()
    {
        $this->evaluation = new ArrayCollection();
    }

    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @ORM\OneToMany(targetEntity="Seances", mappedBy="classe")
     */
    private $seance;

    public function __construct5()
    {
        $this->seance = new ArrayCollection();
    }

    public function getSeance()
    {
        return $this->seance;
    }
}
