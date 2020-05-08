<?php

namespace EM\EstudiantesMatriculasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 

use Doctrine\ORM\EntityRepository;

class MatriculasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periodo', 'choice', array(
            'choices'   => array('2019-1' => '2019-1', '2019-2' => '2019-2',
                                 '2020-1' => '2020-1', '2020-2' => '2020-2',
                                 '2021-1' => '2021-1', '2021-2' => '2021-2')
            ))
            ->add('estudiantes', 'entity', array(
            'class' => 'EMEstudiantesMatriculasBundle:estudiantes',
            'query_builder' => function(EntityRepository $er) {
            return $er->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC');
             },
            ))
            ->add('save', 'submit', array('label' => 'Save'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EM\EstudiantesMatriculasBundle\Entity\Matriculas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'matriculas';
    }
    /**
     * @param OptionsResolver $resolver
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EstudiantesMatriculasBundle\Entity\Matriculas'
        ));
    }
}
