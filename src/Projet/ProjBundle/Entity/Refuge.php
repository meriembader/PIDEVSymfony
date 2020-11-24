<?php

namespace ProjetProjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refuge
 *
 * @ORM\Table(name="refuge", indexes={@ORM\Index(name="fk_Refuge_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Refuge
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @var string
     *
     * @ORM\Column(name="nationnalite", type="string", length=25, nullable=false)
     */
    private $nationnalite;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=20, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="religion", type="string", length=25, nullable=false)
     */
    private $religion;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId = 'NULL';


}

