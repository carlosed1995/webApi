<?php

namespace EM\EstudiantesMatriculasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstudiantesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('nombresApellidos')
            ->add('edad')
            ->add('email','email')
            ->add('save', 'submit', array('label' => 'Save'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EM\EstudiantesMatriculasBundle\Entity\Estudiantes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'em_estudiantesmatriculasbundle_estudiantes';
    }
}
