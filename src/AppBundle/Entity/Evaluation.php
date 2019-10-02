<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", length=255)
     */
    private $note;

    /**
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param float $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
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
     * Set type.
     *
     * @param string $type
     *
     * @return Evaluation
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="evaluation")
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
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="evaluation")
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
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="evaluation")
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
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="evaluation")
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
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="evaluation")
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
