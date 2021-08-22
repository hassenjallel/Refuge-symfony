<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sujetrc
 *
 * @ORM\Table(name="votereponserc")
 * @ORM\Entity
 */
class Votereponserc
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;


    /**
     * @var integer
     *
     * @ORM\Column(name="iduser", type="integer",nullable=true)
     */
    public $iduser;
    /**
     * @var integer
     *
     * @ORM\Column(name="idreponse", type="integer",nullable=true)
     */
    public $idreponse;





}

