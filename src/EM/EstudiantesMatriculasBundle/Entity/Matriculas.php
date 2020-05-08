<?php

namespace EM\EstudiantesMatriculasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Matriculas
 *
 * @ORM\Table(name="matriculas")
 * @ORM\Entity(repositoryClass="EM\EstudiantesMatriculasBundle\Entity\MatriculasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Matriculas
{


    /**
     * @ORM\ManyToOne(targetEntity="Estudiantes", inversedBy="matriculas")
     * @ORM\JoinColumn(name="estudiante_id", referencedColumnName="id", onDelete="CASCADE")
     */ 
    
    protected $estudiantes;


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
     * @ORM\Column(name="periodo", type="string", length=50)
     */
    private $periodo;

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
     * Set periodo
     *
     * @param string $periodo
     * @return Matriculas
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return string 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Matriculas
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
     * @return Matriculas
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
     * Set estudiantes
     *
     * @param \EM\EstudiantesMatriculasBundle\Entity\Estudiantes $estudiantes
     * @return Matriculas
     */
    public function setEstudiantes(\EM\EstudiantesMatriculasBundle\Entity\Estudiantes $estudiantes = null)
    {
        $this->estudiantes = $estudiantes;

        return $this; 
    }

    /**
     * Get estudiantes
     *
     * @return \EM\EstudiantesMatriculasBundle\Entity\Estudiantes 
     */
    public function getEstudiantes()
    { 
        return $this->estudiantes;
    }
}
