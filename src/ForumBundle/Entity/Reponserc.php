<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 *
 * @ORM\Entity
 */
class Reponserc
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idReponseRc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idreponserc;

    /**
     * @var integer
     *
     * @ORM\Column(name="idSujet", type="integer", nullable=true)
     */
    public $idSujet;


    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=250, nullable=true)
     */
    public $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateResponse", type="datetime", nullable=true)
     */
    public $dateresponse;
    /**
     *  @ORM\ManyToOne(targetEntity= UserBundle\Entity\User::class)
     */

    public $user;














}

