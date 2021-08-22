<?php


namespace AssoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="chatbot")
 * @ORM\Entity(repositoryClass="AssoBundle\Repository\chatbotRepository")

 */

class chatbot
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idchat;


    /**
     * @var string
     *
     * @ORM\Column(name="messagechatbot", type="string", nullable=true)
     */
    private $messagechatbot;
    /**
     * @var string
     *
     * @ORM\Column(name="messageuser", type="string", nullable=true)
     */
    private $messageuser;







    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

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
     * @return string
     */
    public function getMessagechatbot()
    {
        return $this->messagechatbot;
    }

    /**
     * @param string $messagechatbot
     */
    public function setMessagechatbot($messagechatbot)
    {
        $this->messagechatbot = $messagechatbot;
    }

    /**
     * @return string
     */
    public function getMessageuser()
    {
        return $this->messageuser;
    }

    /**
     * @param string $messageuser
     */
    public function setMessageuser($messageuser)
    {
        $this->messageuser = $messageuser;
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









}