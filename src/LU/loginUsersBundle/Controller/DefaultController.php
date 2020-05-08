<?php

namespace LU\loginUsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
      //  return $this->render('LUloginUsersBundle:Default:index.html.twig', array('name' => $name));
    	  return $this->render('LUloginUsersBundle:Default:index.html.twig');
    }
}
