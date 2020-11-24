<?php

namespace Projet\ProjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MyFormation
 *
 * @ORM\Table(name="my_formation")
 * @ORM\Entity(repositoryClass="Projet\ProjBundle\Repository\MyFormationRepository")
 */
class MyFormation
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
     * @ORM\Column(name="adresse", type="string", length=30)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_mois", type="integer")
     */
    private $dureeMois;


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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return MyFormation
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set dureeMois
     *
     * @param integer $dureeMois
     *
     * @return MyFormation
     */
    public function setDureeMois($dureeMois)
    {
        $this->dureeMois = $dureeMois;

        return $this;
    }

    /**
     * Get dureeMois
     *
     * @return int
     */
    public function getDureeMois()
    {
        return $this->dureeMois;
    }
}

