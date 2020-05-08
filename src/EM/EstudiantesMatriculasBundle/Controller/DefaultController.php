<?php

namespace EM\EstudiantesMatriculasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EMEstudiantesMatriculasBundle:Default:index.html.twig', array('name' => $name));
    }
}
