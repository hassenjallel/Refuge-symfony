<?php

namespace eventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * particip
 *
 * @ORM\Table(name="particip")
 * @ORM\Entity(repositoryClass="eventBundle\Repository\participRepository")
 */
class particip
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
     * @ORM\Column(name="idevent", type="integer")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="nompart", type="string", length=255)
     */
    private $nompart;


    /**
     * particip constructor.
     * @param int $idevent
     * @param string $nompart
     */
    public function __construct($idevent, $nompart)
    {
        $this->idevent = $idevent;
        $this->nompart = $nompart;
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
     * Set idevent
     *
     * @param integer $idevent
     *
     * @return particip
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;

        return $this;
    }

    /**
     * Get idevent
     *
     * @return int
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * Set nompart
     *
     * @param string $nompart
     *
     * @return particip
     */
    public function setNompart($nompart)
    {
        $this->nompart = $nompart;

        return $this;
    }



    /**
     * Get nompart
     *
     * @return string
     */
    public function getNompart()
    {
        return $this->nompart;
    }
}

