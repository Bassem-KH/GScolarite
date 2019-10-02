<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table(name="seance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeanceRepository")
 */
class Seance
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
     * @ORM\Column(name="salle", type="string", length=255)
     */
    private $salle;

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
     * Set salle.
     *
     * @param string $salle
     *
     * @return Seance
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle.
     *
     * @return string
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Seance
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
     * @ORM\ManyToOne(targetEntity="Cursus", inversedBy="seance")
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
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="seance")
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
}
