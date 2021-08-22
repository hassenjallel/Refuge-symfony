<?php

namespace stockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="stockBundle\Repository\stockRepository")
 */
class stock
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
     * @return stock
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
     * @param string $quantiteDispo
     *
     * @return stock
     */
    public function setQuantiteDispo($quantiteDispo)
    {
        $this->quantiteDispo = $quantiteDispo;

        return $this;
    }

    /**
     * Get quantiteDispo
     *
     * @return string
     */
    public function getQuantiteDispo()
    {
        return $this->quantiteDispo;
    }
}

