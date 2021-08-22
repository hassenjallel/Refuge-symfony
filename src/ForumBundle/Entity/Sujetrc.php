<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sujetrc
 *
 * @ORM\Table(name="sujetrc")
 * @ORM\Entity
 */
/**
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\SujetrcRepository")
 */
class Sujetrc
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idSujetRc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $idsujetrc;

    /**
     *  @ORM\ManyToOne(targetEntity= UserBundle\Entity\User::class) //mapping
     */

    public $user;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=250, nullable=true)
     */
    public $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=45, nullable=true)
     */
    public $categorie;
    /**
     * @var string
     *
     * @ORM\Column(name="titresujet", type="string", length=45, nullable=true)
     */
    public $titresujet;
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="blob")
     */
    public $image;


    /**
     * @var integer
     *
     * @ORM\Column(name="idCategorieRc", type="integer", nullable=true)
     */
    public $idcategorierc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSujet", type="datetime", nullable=true)
     */
    public $datesujet;

    /**
     * @var integer
     *
     * @ORM\Column(name="priorite", type="integer", nullable=true)
     */
    public $priorite;

    /**
     * @var integer
     *
     * @ORM\Column(name="resolue", type="integer", nullable=true)
     */
    public $resolue;

    /**
    * Set image
    *
    * @param string $image
    *
    * @return Sujetrc;
    */

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


    private $rawPhoto;

    public function displayPhoto2()
    {
        if(null === $this->rawPhoto) {
            $this->rawPhoto = "data:image/png;base64," . base64_encode(stream_get_contents($this->getImage()));
        }

        return $this->rawPhoto;
    }




}

