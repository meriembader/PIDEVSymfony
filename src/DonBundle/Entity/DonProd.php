<?php

namespace DonBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DonProd
 *
 * @ORM\Table(name="don_prod", indexes={@ORM\Index(name="id_prod", columns={"id_prod"}), @ORM\Index(name="f1", columns={"id_prod"})})
 * @ORM\Entity
 */
class DonProd
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_don", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDon = '0';

    /**
     * @var integer
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="qt", type="integer", nullable=false)
     */
    private $qt;

    /**
     * @var \DateTime
     *@Assert\GreaterThan(value="today")
     * @Assert\NotBlank

     * @Assert\DateTime()
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=false)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=30, nullable=false)
     */
    private $lieu;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_prod", referencedColumnName="id_prod")
     * })
     */
    private $idProd;

    /**
     * @return int
     */
    public function getIdDon()
    {
        return $this->idDon;
    }

    /**
     * @param int $idDon
     */
    public function setIdDon($idDon)
    {
        $this->idDon = $idDon;
    }

    /**
     * @return int
     */
    public function getQt()
    {
        return $this->qt;
    }

    /**
     * @param int $qt
     */
    public function setQt($qt)
    {
        $this->qt = $qt;
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
     * @throws \Exception
     */
    public function setDate($date)
    {

        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param \DateTime $heure
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;
    }

    /**
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param string $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return \Produit
     */
    public function getIdProd()
    {
        return $this->idProd;
    }

    /**
     * @param \Produit $idProd
     */
    public function setIdProd($idProd)
    {
        $this->idProd = $idProd;
    }


}

