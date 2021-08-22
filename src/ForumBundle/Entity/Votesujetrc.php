<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponserc
 *
 * @ORM\Table(name="votesujetrc")
 * @ORM\Entity
 */
class Votesujetrc
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
     * @ORM\Column(name="idsujet", type="integer", nullable=true)
     */
    public $idsujet;

    /**
     * @var integer
     *
     * @ORM\Column(name="iduser", type="integer", nullable=true)
     */
    public $iduser;

    /**
     * @var integer
     *
     * @ORM\Column(name="updown", type="integer", nullable=true)
     */
    public $updown;




}

