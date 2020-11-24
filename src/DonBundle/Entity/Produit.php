<?php

namespace DonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit", uniqueConstraints={@ORM\UniqueConstraint(name="libelle_prod", columns={"libelle_prod"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_prod", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProd;

    /**
     * @return int
     */
    public function getIdProd()
    {
        return $this->idProd;
    }

    /**
     * @param int $idProd
     */
    public function setIdProd($idProd)
    {
        $this->idProd = $idProd;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getLibelleProd()
    {
        return $this->libelleProd;
    }

    /**
     * @param string $libelleProd
     */
    public function setLibelleProd($libelleProd)
    {
        $this->libelleProd = $libelleProd;
    }

    /**
     * @var string
     * @Assert\Length(8)
     * @ORM\Column(name="categorie", type="string", length=30, nullable=true)
     */
    private $categorie;

    /**
     * @var string
     * @Assert\Length(8)
     * @ORM\Column(name="libelle_prod", type="string", length=30, nullable=true)
     */
    private $libelleProd;


}

