<?php


namespace familleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_asso_famille")
 * @ORM\Entity(repositoryClass="familleBundle\Repository\messageRepository")
 */

class message
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;





    /**
     * @var integer
     *
     * @ORM\Column(name="id_message", type="integer", nullable=true)
     */
    private $idMessage;







    /**
     * @var string
     *
     * @ORM\Column(name="login_envoi", type="string", nullable=true)
     */
    private $loginEnvoi;



    /**
     * @var string
     *
     * @ORM\Column(name="login_recep", type="string", nullable=true)
     */
    private $loginRecep;




    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", nullable=true)
     */
    private $message;






    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;


    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", nullable=true)
     */
    private $role;


    /**
     * @var integer
     *
     * @ORM\Column(name="id_recep", type="integer", nullable=true)
     */
    private $idRecep;




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
     * @return int
     */
    public function getIdMessage()
    {
        return $this->idMessage;
    }

    /**
     * @param mixed $idMessage
     *
     */
    public function setIdMessage($idMessage)
    {
        $this->idMessage = $idMessage;
    }

    /**
     * @return string
     */
    public function getLoginEnvoi()
    {
        return $this->loginEnvoi;
    }

    /**
     * @param string $loginEnvoi
     */
    public function setLoginEnvoi($loginEnvoi)
    {
        $this->loginEnvoi = $loginEnvoi;
    }

    /**
     * @return string
     */
    public function getLoginRecep()
    {
        return $this->loginRecep;
    }

    /**
     * @param string $loginRecep
     */
    public function setLoginRecep($loginRecep)
    {
        $this->loginRecep = $loginRecep;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getIdRecep()
    {
        return $this->idRecep;
    }

    /**
     * @param int $idRecep
     */
    public function setIdRecep($idRecep)
    {
        $this->idRecep = $idRecep;
    }










}