<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MatiereRepository")
 */
class Matiere
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
     * @var string
     *
     * @ORM\Column(name="semestre", type="string", length=255)
     */
    private $semestre;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_absences", type="integer")
     */
    private $nombreAbsences;

    /**
     * @var float
     *
     * @ORM\Column(name="coefficient", type="float")
     */
    private $coefficient;


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
     * @return Matiere
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
     * Set semestre.
     *
     * @param string $semestre
     *
     * @return Matiere
     */
    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * Get semestre.
     *
     * @return string
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * Set nombreAbsences.
     *
     * @param int $nombreAbsences
     *
     * @return Matiere
     */
    public function setNombreAbsences($nombreAbsences)
    {
        $this->nombreAbsences = $nombreAbsences;

        return $this;
    }

    /**
     * Get nombreAbsences.
     *
     * @return int
     */
    public function getNombreAbsences()
    {
        return $this->nombreAbsences;
    }

    /**
     * Set coefficient.
     *
     * @param float $coefficient
     *
     * @return Matiere
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient.
     *
     * @return float
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="matiere")
     */
    private $module;

    public function setModule(Module $module)
    {
        $this->module = $module;
    }

    public function getModule()
    {
        return $this->module;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="matiere")
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
     * @ORM\OneToMany(targetEntity="Assiduite", mappedBy="matiere")
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
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="matiere")
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

    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="matiere")
     */
    private $matiere;

    public function __construct3()
    {
        $this->matiere = new ArrayCollection();
    }

    public function getMatiere()
    {
        return $this->matiere;
    }
}
