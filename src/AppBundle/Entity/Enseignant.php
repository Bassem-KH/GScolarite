<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Enseignant
 *
 * @ORM\Table(name="enseignant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnseignantRepository")
 */
class Enseignant
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
     * @return Enseignant
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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Classe", inversedBy="enseignant")
     * @ORM\JoinTable(name="ensClasse")
     */
    protected $classes;

    /**
     * @return ArrayCollection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @param ArrayCollection $classes
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
    }

    /**
     * @ORM\OneToMany(targetEntity="Seances", mappedBy="enseignant")
     */
    private $seances;

    public function __construct2()
    {
        $this->seances = new ArrayCollection();
    }

    public function getSeances()
    {
        return $this->seances;
    }




}
