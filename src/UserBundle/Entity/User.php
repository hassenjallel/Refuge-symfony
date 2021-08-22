<?php


namespace UserBundle\Entity;



use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;






/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */


class User extends BaseUser
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
     * @ORM\Column(name="nom_db", type="string", nullable=true)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="prenom_db", type="string", nullable=true)
     */
    private $prenom;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe_db", type="string", nullable=true)
     */
    private $sexe;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="d_naissance_db", type="date", nullable=true)
     */
    private $date_naissance;


    /**
     * @var integer
     *
     * @ORM\Column(name="tel_db", type="integer", nullable=true)
     */
    private $tel;

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_db", type="string", nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="add_db", type="string", nullable=true)
     */
    private $add;
    /**
     * @var string
     *
     * @ORM\Column(name="quest_db", type="string", nullable=true)
     */
    private $quest;


    /**
     * @var string
     *
     * @ORM\Column(name="image_db", type="string", length=250, nullable=true)
     */
    private $image;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", nullable=true)
     */
    private $etat;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer", nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine_db", type="string", nullable=true)
     */
    private $domaine;


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
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getAdd()
    {
        return $this->add;
    }

    /**
     * @param string $add
     */
    public function setAdd($add)
    {
        $this->add = $add;
    }

    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * @param \DateTime $date_naissance
     */
    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;
    }

    /**
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * @param string $domaine
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;
    }












    private $rawPhoto;

    public function displayPhoto()
    {
        if(null === $this->rawPhoto) {
            $this->rawPhoto = "data:image/png;base64," . base64_encode(stream_get_contents($this->getImage()));
        }

        return $this->rawPhoto;
    }


    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
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
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



   // private $file;

/*
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->setImage(file_get_contents($this->getFile()));
    }
*/
}