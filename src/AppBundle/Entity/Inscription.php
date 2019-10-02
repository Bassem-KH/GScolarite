<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Inscription
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InscriptionRepository")
 * @UniqueEntity("cin")
 */
class Inscription
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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @var string
     *
     *@Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "CIN must be at least {{ limit }} characters long",
     *      maxMessage = "Your CIN cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="cin", type="integer", length=8, unique=true)
     */
    private $cin;

    /**
     * @var string
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;


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
     * @return Inscription
     */
    public function setNom($nom)
    {
        $this->nom =strtoupper($nom);

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
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return Inscription
     */
    public function setPrenom($prenom)
    {
        $this->prenom =$prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set cin.
     *
     * @param string $cin
     *
     * @return Inscription
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin.
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Inscription
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Specc", inversedBy="inscription")
     */
    private $specc;

    public function setSpecc(Specc $specc)
    {
        $this->specc = $specc;
    }

    public function getSpecc()
    {
        return $this->specc;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Cycle", inversedBy="inscription")
     */
    private $cycle;

    public function setCycle(Cycle $cycle)
    {
        $this->cycle = $cycle;
    }

    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Veuillez télécharger vos relevés de notes sous forme de fichier PDF.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $releve;

    public function getReleve()
    {
        return $this->releve;
    }

    public function setReleve($releve)
    {
        $this->releve= $releve;

        return $this;
    }


}
