<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Courses
 *
 * @ORM\Table(name="courses")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoursesRepository")
 */
class Courses
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
     * @Assert\GreaterThanOrEqual(
     *     value = 3
     * )
     * @ORM\Column(name="prix", type="string", length=255)
     */
    private $prix;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="adresse_depart", type="string", length=255)
     */
    private $adresseDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_arrivee", type="string", length=255)
     */
    private $adresseArrivee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_livraison", type="datetime")
     */
    private $dateLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Villes", inversedBy="courses")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commentaires", mappedBy="course")
     */
    private $commentaires;



    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="courses")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param mixed $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }




    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }






    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Courses
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Courses
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set adresseDepart
     *
     * @param string $adresseDepart
     *
     * @return Courses
     */
    public function setAdresseDepart($adresseDepart)
    {
        $this->adresseDepart = $adresseDepart;

        return $this;
    }

    /**
     * Get adresseDepart
     *
     * @return string
     */
    public function getAdresseDepart()
    {
        return $this->adresseDepart;
    }

    /**
     * Set adresseArrivee
     *
     * @param string $adresseArrivee
     *
     * @return Courses
     */
    public function setAdresseArrivee($adresseArrivee)
    {
        $this->adresseArrivee = $adresseArrivee;

        return $this;
    }

    /**
     * Get adresseArrivee
     *
     * @return string
     */
    public function getAdresseArrivee()
    {
        return $this->adresseArrivee;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Courses
     */
    public function setCreatedAt($createdAt)
    {

        $this->createdAt = $createdAt;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }


    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set dateLivraison
     *
     * @param \DateTime $dateLivraison
     *
     * @return Courses
     */
    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    /**
     * Get dateLivraison
     *
     * @return \DateTime
     */
    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Courses
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

