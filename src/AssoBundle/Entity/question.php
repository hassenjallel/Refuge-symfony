<?php


namespace AssoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * question
 *
 * @ORM\Entity
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AssoBundle\Repository\questRepository")
 */

class question implements NotifiableInterface, \JsonSerializable

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
     * @ORM\Column(name="idquest", type="integer", nullable=true)
     */
    private $idquest;


    /**
     * @var string
     *
     * @ORM\Column(name="quest", type="string", nullable=true)
     */
    private $quest;


    /**
     * @var string
     *
     * @ORM\Column(name="rep", type="string", nullable=true)
     */
    private $rep;
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;




    /**
     * @var integer
     *
     * @ORM\Column(name="val", type="integer", nullable=true)
     */
    private $val;





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
    public function getIdquest()
    {
        return $this->idquest;
    }

    /**
     * @param int $idquest
     */
    public function setIdquest($idquest)
    {
        $this->idquest = $idquest;
    }

    /**
     * @return string
     */
    public function getQuest()
    {
        return $this->quest;
    }

    /**
     * @param string $quest
     */
    public function setQuest($quest)
    {
        $this->quest = $quest;
    }

    /**
     * @return string
     */
    public function getRep()
    {
        return $this->rep;
    }

    /**
     * @param string $rep
     */
    public function setRep($rep)
    {
        $this->rep = $rep;
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
     * @return int
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * @param int $val
     */
    public function setVal($val)
    {
        $this->val = $val;
    }
    public function notificationsOnCreate(NotificationBuilder $builder)
    {

        $notification = new Notification();
        $notification
            ->setTitle('Question : '.$this->quest)
            ->setDescription(' New Value : '.$this->val.'" has been added')
            ->setRoute('redi')// I suppose you have a show route for your entity
            ->setParameters(array('id' => $this->id))
            ->setid2($this->id)

        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {

        $notification = new Notification();
        $notification
            ->setTitle('Question : '.$this->quest)
            ->setDescription('Value : '.$this->val.'" has been updated')
            ->setRoute('redi' )
            ->setParameters(array('id' => $this->id))
            ->setid2($this->id)

        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // in case you don't want any notification for a special event
        // you can simply return an empty $builder
        return $builder;
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }


}