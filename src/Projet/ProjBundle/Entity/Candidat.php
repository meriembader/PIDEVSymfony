<?php

namespace ProjetProjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidat
 *
 * @ORM\Table(name="candidat", indexes={@ORM\Index(name="fk_candidat_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Candidat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idc;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=25, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=8, nullable=false)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=8, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=25, nullable=false)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="critere", type="string", length=25, nullable=false)
     */
    private $critere;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId = 'NULL';


}

