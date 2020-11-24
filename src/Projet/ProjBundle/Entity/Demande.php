<?php

namespace ProjetProjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity
 */
class Demande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_demande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDemande;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=30, nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=30, nullable=false)
     */
    private $libelle;


}

