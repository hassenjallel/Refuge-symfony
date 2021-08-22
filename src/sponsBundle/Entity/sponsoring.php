<?php

namespace sponsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * sponsoring
 *
 * @ORM\Table(name="sponsorings")
 * @ORM\Entity(repositoryClass="sponsBundle\Repository\sponsoringRepository")
 */
class sponsoring
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_assosiation", type="string", length=255)
     */
    private $nomAssosiation;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=255)
     */
    private $domaine;


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
     * Set email
     *
     * @param string $email
     *
     * @return sponsoring
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nomAssosiation
     *
     * @param string $nomAssosiation
     *
     * @return sponsoring
     */
    public function setNomAssosiation($nomAssosiation)
    {
        $this->nomAssosiation = $nomAssosiation;

        return $this;
    }

    /**
     * Get nomAssosiation
     *
     * @return string
     */
    public function getNomAssosiation()
    {
        return $this->nomAssosiation;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return sponsoring
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set domaine
     *
     * @param string $domaine
     *
     * @return sponsoring
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }
}

