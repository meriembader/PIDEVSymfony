<?php

namespace DonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Don
 *
 * @ORM\Table(name="don", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Don
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_don", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_don", type="date", nullable=true)
     */
    private $dateDon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_don", type="time", nullable=true)
     */
    private $heureDon;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * Don constructor.
     * @param int $etat
     * @param int $type
     * @param int $idUser
     */
    public function __construct($etat, $type, $idUser)
    {
        $this->etat = $etat;
        $this->type = $type;
        $this->idUser = $idUser;
         $this->dateDon = new \DateTime();
        $this->heureDon = new \DateTime();
    }

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
     * @return \DateTime
     */
    public function getDateDon()
    {
        return $this->dateDon;
    }

    /**
     * @param \DateTime $dateDon
     */
    public function setDateDon($dateDon)
    {
        $this->dateDon = $dateDon;
    }

    /**
     * @return \DateTime
     */
    public function getHeureDon()
    {
        return $this->heureDon;
    }

    /**
     * @param \DateTime $heureDon
     */
    public function setHeureDon($heureDon)
    {
        $this->heureDon = $heureDon;
    }

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }


}

