<?php

namespace AssociationBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 *  Association
 */
class Association
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $raisonSociale;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $address;

    /**
     * @var int
     * @Assert\LessThanOrEqual(value="9999999999999", message="Entrer exactement 8 chiffres !! ")
     * @Assert\GreaterThanOrEqual(value="9999999", message="Entrer exactement 8 chiffres !! ")
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $telephone;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $domaine;
    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $gouvernorat;


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
     * Set raisonSociale
     *
     * @param string $raisonSociale
     *
     * @return Association
     */
    public function setRaisonSociale($raisonSociale)
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Get raisonSociale
     *
     * @return string
     */
    public function getRaisonSociale()
    {
        return $this->raisonSociale;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Association
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Association
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set domaine
     *
     * @param string $domaine
     *
     * @return Association
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set gouvernorat
     *
     * @param string $gouvernorat
     *
     * @return Association
     */
    public function setGouvernorat($gouvernorat)
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    /**
     * Get gouvernorat
     *
     * @return string
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }
}

