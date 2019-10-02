<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cursus
 *
 * @ORM\Table(name="cursus")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CursusRepository")
 */
class Cursus
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
     * @return Cursus
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
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=255)
     */
    private $abreviation;

    /**
     * @return string
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * @param string $abreviation
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;
    }
    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="cursus")
     */
    private $module;

    public function __construct()
    {
        $this->module = new ArrayCollection();
    }

    public function getModule()
    {
        return $this->module;
    }


    /**
     * @ORM\OneToMany(targetEntity="Matiere", mappedBy="cursus")
     */
    private $matiere;

    public function __construct6()
    {
        $this->matiere = new ArrayCollection();
    }

    public function getMatiere()
    {
        return $this->matiere;
    }
    /**
     * @ORM\OneToMany(targetEntity="Classe", mappedBy="cursus")
     */
    private $classe;

    public function __construct2()
    {
        $this->classe = new ArrayCollection();
    }

    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @ORM\OneToMany(targetEntity="Assiduite", mappedBy="cursus")
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
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="cursus")
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
     * @ORM\OneToMany(targetEntity="Seances", mappedBy="cursus")
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

    /**
     * @ORM\ManyToOne(targetEntity="Specialite", inversedBy="cursus")
     */
    private $specialite;

    public function setSpecialite(Specialite $specialite)
    {
        $this->specialite = $specialite;
    }

    public function getSpecialite()
    {
        return $this->specialite;
    }
}
