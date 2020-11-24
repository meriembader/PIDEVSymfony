<?php

namespace BenevoleBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Benevole
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     * @Assert\LessThanOrEqual(value="99999999", message="Entrer exactement 8 chiffres !! ")
     * @Assert\GreaterThanOrEqual(value="9999999", message="Entrer exactement 8 chiffres !! ")
     * @Assert\NotBlank(message="Ce champs est obligatoire")

     */
    private $cin;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $address;

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $mail;

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
    private $niveau;

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
     * Set cin
     *
     * @param integer $cin
     *
     * @return Benevole
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Benevole
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
     * Set mail
     *
     * @param string $mail
     *
     * @return Benevole
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Benevole
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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return Benevole
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set gouvernorat
     *
     * @param string $gouvernorat
     *
     * @return Benevole
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

