<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assiduite
 *
 * @ORM\Table(name="assiduite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AssiduiteRepository")
 */
class Assiduite
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Assiduite
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="assiduite")
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
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="assiduite")
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
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="assiduite")
     */
    private $etudiant;

    public function setEtudiant(Etudiant $etudiant)
    {
        $this->etudiant = $etudiant;
    }

    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="assiduite")
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
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="assiduite")
     */
    private $matiere;

    public function setMatiere(Matiere $matiere)
    {
        $this->matiere = $matiere;
    }

    public function getMatiere()
    {
        return $this->matiere;
    }
}
