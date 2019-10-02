<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalleRepository")
 */
class Salle
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
     * @var int
     *
     * @ORM\Column(name="NumSalle", type="integer", unique=true)
     */
    private $numSalle;

    /**
     * @var int
     *
     * @ORM\Column(name="nbTables", type="integer")
     */
    private $nbTables;

    /**
     * @var int
     *
     * @ORM\Column(name="nbChaises", type="integer")
     */
    private $nbChaises;


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
     * Set numSalle.
     *
     * @param int $numSalle
     *
     * @return Salle
     */
    public function setNumSalle($numSalle)
    {
        $this->numSalle = $numSalle;

        return $this;
    }

    /**
     * Get numSalle.
     *
     * @return int
     */
    public function getNumSalle()
    {
        return $this->numSalle;
    }

    /**
     * Set nbTables.
     *
     * @param int $nbTables
     *
     * @return Salle
     */
    public function setNbTables($nbTables)
    {
        $this->nbTables = $nbTables;

        return $this;
    }

    /**
     * Get nbTables.
     *
     * @return int
     */
    public function getNbTables()
    {
        return $this->nbTables;
    }

    /**
     * Set nbChaises.
     *
     * @param int $nbChaises
     *
     * @return Salle
     */
    public function setNbChaises($nbChaises)
    {
        $this->nbChaises = $nbChaises;

        return $this;
    }

    /**
     * Get nbChaises.
     *
     * @return int
     */
    public function getNbChaises()
    {
        return $this->nbChaises;
    }
    /**
     * @ORM\OneToMany(targetEntity="Classe", mappedBy="salle")
     */
    private $classe;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
    }

    public function getClasse()
    {
        return $this->classe;
    }

}
