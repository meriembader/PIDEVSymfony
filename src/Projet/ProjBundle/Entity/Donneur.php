<?php

namespace ProjetProjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donneur
 *
 * @ORM\Table(name="donneur", indexes={@ORM\Index(name="fk_Donneur_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Donneur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idD", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idd;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=25, nullable=false)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="point", type="string", length=255, nullable=false)
     */
    private $point;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=8, nullable=false)
     */
    private $telephone;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId = 'NULL';


}

