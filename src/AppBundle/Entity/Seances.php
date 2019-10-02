<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seances
 *
 * @ORM\Table(name="seances")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeancesRepository")
 */
class Seances
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
     * @ORM\Column(name="jours", type="string", length=255)
     */
    private $jours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempsDebut", type="time")
     */
    private $tempsDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempsFin", type="time")
     */
    private $tempsFin;


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
     * Set jours.
     *
     * @param string $jours
     *
     * @return Seances
     */
    public function setJours($jours)
    {
        $this->jours = $jours;

        return $this;
    }

    /**
     * Get jours.
     *
     * @return string
     */
    public function getJours()
    {
        return $this->jours;
    }

    /**
     * Set tempsDebut.
     *
     * @param \DateTime $tempsDebut
     *
     * @return Seances
     */
    public function setTempsDebut($tempsDebut)
    {
        $this->tempsDebut = $tempsDebut;

        return $this;
    }

    /**
     * Get tempsDebut.
     *
     * @return \DateTime
     */
    public function getTempsDebut()
    {
        return $this->tempsDebut;
    }

    /**
     * Set tempsFin.
     *
     * @param \DateTime $tempsFin
     *
     * @return Seances
     */
    public function setTempsFin($tempsFin)
    {
        $this->tempsFin = $tempsFin;

        return $this;
    }

    /**
     * Get tempsFin.
     *
     * @return \DateTime
     */
    public function getTempsFin()
    {
        return $this->tempsFin;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="seances")
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
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="seances")
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
     * @ORM\ManyToOne(targetEntity="Enseignant", inversedBy="seances")
     */
    private $enseignant;

    public function setEnseignant(Enseignant $enseignant)
    {
        $this->enseignant = $enseignant;
    }

    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="seances")
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
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="seances")
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
    /**
     * @ORM\ManyToOne(targetEntity="Salle", inversedBy="seances")
     */
    private $salle;

    public function setSalle(Salle $salle)
    {
        $this->salle = $salle;
    }

    public function getSalle()
    {
        return $this->salle;
    }

}
