<?php

namespace ProjetProjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docteur
 *
 * @ORM\Table(name="docteur", indexes={@ORM\Index(name="fk_Docteur_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Docteur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idDoc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddoc;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=8, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=25, nullable=false)
     */
    private $specialite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=25, nullable=false)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId = 'NULL';


}

