<?php

namespace sponsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * besoins
 *
 * @ORM\Table(name="besoins")
 * @ORM\Entity(repositoryClass="sponsBundle\Repository\besoinsRepository")
 */
class besoins
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
     * @ORM\Column(name="nom_produit", type="string", length=255)
     */
    private $nomProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="quantite_dispo", type="float")
     */
    private $quantiteDispo;

    /**
     * @var int
     *
     * @ORM\Column(name="nos_besoins", type="integer")
     */
    private $nosBesoins;

    /**
     * besoins constructor.
     * @param string $nomProduit
     * @param float $quantiteDispo
     * @param int $nosBesoins
     */
    public function __construct($nomProduit, $quantiteDispo, $nosBesoins)
    {
        $this->nomProduit = $nomProduit;
        $this->quantiteDispo = $quantiteDispo;
        $this->nosBesoins = $nosBesoins;
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
     * Set nomProduit
     *
     * @param string $nomProduit
     *
     * @return besoins
     */
    public function setNomProduit($nomProduit)
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    /**
     * Get nomProduit
     *
     * @return string
     */
    public function getNomProduit()
    {
        return $this->nomProduit;
    }

    /**
     * Set quantiteDispo
     *
     * @param float $quantiteDispo
     *
     * @return besoins
     */
    public function setQuantiteDispo($quantiteDispo)
    {
        $this->quantiteDispo = $quantiteDispo;

        return $this;
    }

    /**
     * Get quantiteDispo
     *
     * @return float
     */
    public function getQuantiteDispo()
    {
        return $this->quantiteDispo;
    }

    /**
     * Set nosBesoins
     *
     * @param integer $nosBesoins
     *
     * @return besoins
     */
    public function setNosBesoins($nosBesoins)
    {
        $this->nosBesoins = $nosBesoins;

        return $this;
    }

    /**
     * Get nosBesoins
     *
     * @return int
     */
    public function getNosBesoins()
    {
        return $this->nosBesoins;
    }


}

