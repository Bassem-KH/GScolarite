<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleRepository")
 */
class Module
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
     * @return Module
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
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="module")
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
     * @ORM\OneToMany(targetEntity="Matiere", mappedBy="module")
     */
    private $matiere;

    public function __construct()
    {
        $this->matiere = new ArrayCollection();
    }

    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * @ORM\OneToMany(targetEntity="Assiduite", mappedBy="module")
     */
    private $assiduite;

    public function __construct2()
    {
        $this->assiduite = new ArrayCollection();
    }

    public function getAssiduite()
    {
        return $this->assiduite;
    }

    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="module")
     */
    private $evaluation;

    public function __construct3()
    {
        $this->evaluation = new ArrayCollection();
    }

    public function getEvaluation()
    {
        return $this->evaluation;
    }
}
