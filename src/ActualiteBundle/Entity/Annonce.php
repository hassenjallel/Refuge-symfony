<?php

namespace ActualiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="ActualiteBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @ORM\Column(name="type_mission", type="string", length=255)
     */
    private $typeMission;

    /**
     * @var string
     *
     * @ORM\Column(name="public_cible", type="string", length=255)
     */
    private $publicCible;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="code_postal", type="integer")
     */
    private $codePostal;
    /** string     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    public $image;


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
     * Set typeMission
     *
     * @param string $typeMission
     *
     * @return Annonce
     */
    public function setTypeMission($typeMission)
    {
        $this->typeMission = $typeMission;

        return $this;
    }

    /**
     * Get typeMission
     *
     * @return string
     */
    public function getTypeMission()
    {
        return $this->typeMission;
    }

    /**
     * Set publicCible
     *
     * @param string $publicCible
     *
     * @return Annonce
     */
    public function setPublicCible($publicCible)
    {
        $this->publicCible = $publicCible;

        return $this;
    }

    /**
     * Get publicCible
     *
     * @return string
     */
    public function getPublicCible()
    {
        return $this->publicCible;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Annonce
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

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Annonce
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Annonce
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }
    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}

