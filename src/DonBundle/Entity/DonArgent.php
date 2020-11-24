<?php

namespace DonBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * DonArgent
 *
 * @ORM\Table(name="don_argent")
 * @ORM\Entity
 */
class DonArgent
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
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="somme", type="integer", nullable=false)
     */
    private $somme;

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
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * @param int $somme
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;
    }



}

