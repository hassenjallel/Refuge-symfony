<?php

namespace ActualiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * fosmobile
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="ActualiteBundle\Repository\fosmobileRepository")
 */
class fosmobile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="login_db", type="string", nullable=true)
     */
    public $login_db;
    /**
     * @var string
     *
     * @ORM\Column(name="email_db", type="string", nullable=true)
     */
    public $email_db;
    /**
     * @var string
     *
     * @ORM\Column(name="mdp_db", type="string", nullable=true)
     */
    public $mdp_db;
    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string", nullable=true)
     */
    public $roles;

    /**
     * fosmobile constructor.
     * @param string $login_db
     * @param string $email_db
     * @param string $mdp_db
     * @param string $roles
     */
    public function __construct(string $login_db,string $email_db , string $mdp_db, string $roles)
    {
        $this->login_db = $login_db;
        $this->email_db = $email_db;
        $this->mdp_db = $mdp_db;
        $this->roles = $roles;
    }


    /**
     * @return mixed
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @param string $roles
     */
    public function setroles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getroles()
    {
        return $this->roles;
    }
    

    /**
     * @return string
     */
    public function getmdp_db()
    {
        return $this->mdp_db;
    }

    /**
     * @param string $mdp_db
     */
    public function setmdp_db($mdp_db)
    {
        $this->mdp_db = $mdp_db;
    }
    /**
     * @return string
     */
    public function getLogin_db()
    {
        return $this->login_db;
    }

    /**
     * @param string $login_db
     */
    public function setLogin_db($login_db)
    {
        $this->login_db = $login_db;
    }
    /**
     * @return string
     */
    public function getEmail_db()
    {
        return $this->email_db;
    }

    /**
     * @param string $email_db
     */
    public function setEmail_db($email_db)
    {
        $this->email_db = $email_db;
    }







}

