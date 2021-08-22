<?php

namespace AssoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity
 */
class Notification extends BaseNotification implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId2()
    {
        return $this->id2;
    }

    /**
     * @param int $id2
     */
    public function setId2($id2)
    {
        $this->id2 = $id2;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", nullable=true)
     */
    private $user;

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



    /**
     * @var int
     *
     * @ORM\Column(name="id2", type="integer")
     */
    protected $id2;

    public function __construct()
    {
        parent::__construct();
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }


}