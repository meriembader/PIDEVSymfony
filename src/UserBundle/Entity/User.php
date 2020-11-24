<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string")
     */
    private $prenom;
    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string")
     */
    private $tel;
    /**
     * @var string
     *
     * @ORM\Column(name="dispoTime", type="string")
     */
    private $dispoTime;
    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string")
     */
    private $statut;


    /**
     * @ORM\ManyToMany(targetEntity="EventBundle\Entity\Event",mappedBy="participants")
     */
    private $evenements;


    /**
     * @ORM\OneToMany(targetEntity="EventBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        parent:: __construct();
        $this->addRole("ROLE_CLIENT");

    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set dispoTime
     *
     * @param string $dispoTime
     *
     * @return User
     */
    public function setDispoTime($dispoTime)
    {
        $this->dispoTime = $dispoTime;

        return $this;
    }

    /**
     * Get dispoTime
     *
     * @return string
     */
    public function getDispoTime()
    {
        return $this->dispoTime;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return User
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }
    /**
     * @ORM\ManyToOne(targetEntity="ManagementServiceBundle\Entity\School", inversedBy="users")
     */
    private $school;

    /**
     * @ORM\ManyToOne(targetEntity="LogementBundle\Entity\Logement", inversedBy="users")
     */
    private $logement;


    /**
     * Set school
     *
     * @param \ManagementServiceBundle\Entity\School $school
     *
     * @return User
     */
    public function setSchool(\ManagementServiceBundle\Entity\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \ManagementServiceBundle\Entity\School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Add evenement
     *
     * @param \EventBundle\Entity\Event $evenement
     *
     * @return User
     */
    public function addEvenement(\EventBundle\Entity\Event $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Remove evenement
     *
     * @param \EventBundle\Entity\Event $evenement
     */
    public function removeEvenement(\EventBundle\Entity\Event $evenement)
    {
        $this->evenements->removeElement($evenement);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * Add comment
     *
     * @param \EventBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\EventBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \EventBundle\Entity\Comment $comment
     */
    public function removeComment(\EventBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set logement
     *
     * @param \LogementBundle\Entity\Logement $logement
     *
     * @return User
     */
    public function setLogement(\LogementBundle\Entity\Logement $logement = null)
    {
        $this->logement = $logement;

        return $this;
    }

    /**
     * Get logement
     *
     * @return \LogementBundle\Entity\Logement
     */
    public function getLogement()
    {
        return $this->logement;
    }
}
