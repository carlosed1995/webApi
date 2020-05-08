<?php

namespace EM\EstudiantesMatriculasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Estudiantes
 *
 * @ORM\Table(name="estudiantes")
 * @ORM\Entity(repositoryClass="EM\EstudiantesMatriculasBundle\Entity\EstudiantesRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("codigo")
 * @ORM\HasLifecycleCallbacks()
 */
class Estudiantes
{


    /**
     * @ORM\OneToMany(targetEntity="Matriculas", mappedBy="estudiantes")
     */ 

    protected $matriculas;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres_apellidos", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombresApellidos;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer")
     * @Assert\NotBlank()
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->matriculas = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Estudiantes
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombresApellidos
     *
     * @param string $nombresApellidos
     * @return Estudiantes
     */
    public function setNombresApellidos($nombresApellidos)
    {
        $this->nombresApellidos = $nombresApellidos;

        return $this;
    }

    /**
     * Get nombresApellidos
     *
     * @return string 
     */
    public function getNombresApellidos()
    {
        return $this->nombresApellidos;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Estudiantes
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Estudiantes
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Estudiantes
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Estudiantes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /** 
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Add matriculas
     *
     * @param \EM\EstudiantesMatriculasBundle\Entity\Matriculas $matriculas
     * @return Estudiantes
     */
    public function addMatricula(\EM\EstudiantesMatriculasBundle\Entity\Matriculas $matriculas)
    {
        $this->matriculas[] = $matriculas;

        return $this;
    }

    /**
     * Remove matriculas
     *
     * @param \EM\EstudiantesMatriculasBundle\Entity\Matriculas $matriculas
     */
    public function removeMatricula(\EM\EstudiantesMatriculasBundle\Entity\Matriculas $matriculas)
    {
        $this->matriculas->removeElement($matriculas);
    }

    /**
     * Get matriculas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatriculas()
    {
        return $this->matriculas;
    }

    public function __toString()
    {
      return $this->nombresApellidos . " - " . $this->codigo;
    }

}
