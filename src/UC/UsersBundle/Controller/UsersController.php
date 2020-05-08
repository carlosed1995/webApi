<?php

namespace UC\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use UC\UsersBundle\Entity\Users;
use UC\UsersBundle\Form\UsersType;

class UsersController extends Controller
{
    public function homeAction()
    {
        return $this->render('UCUsersBundle:Users:home.html.twig');
    }

    public function indexAction()
    {
       $uc = $this->getDoctrine()->getManager();
       $users = $uc->getRepository('UCUsersBundle:Users')->findAll();
 
       $deleteFormAjax = $this->createCustomForm(':USER_ID', 'DELETE', 'uc_users_delete');
       return $this->render('UCUsersBundle:Users:index.html.twig', array('users' => $users,'delete_form_ajax' => $deleteFormAjax->createView())); 
    }
 
    public function viewAction($id)
    {

    }
 

    public function addAction()
    {
        $user = new Users();
        $form = $this->createCreateForm($user);
        
        return $this->render('UCUsersBundle:Users:add.html.twig', array('form' => $form->createView()));
    }

    private function createCreateForm(Users $entity)
    {
        $form = $this->createForm(new UsersType(), $entity, array(
                'action' => $this->generateUrl('uc_users_create'),
                'method' => 'POST'
            ));
        
        return $form;
    }

      public function createAction(Request $request)
    {   
        $user = new Users();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        
        if($form->isValid())
        {       
        	
         $factory = $this->get('security.encoder_factory');
         $user->setSalt(md5(time()));
         $encoder = $factory->getEncoder($user);
         $password = $encoder->encodePassword('user_password', $user->getSalt());
         $user->setPassword($password);
           
                $uc = $this->getDoctrine()->getManager();
                $uc->persist($user);
                $uc->flush();

                $successMessage = 'El usuario ha sido creado.';
                $this->get('session')->getFlashBag()->add('success', $successMessage);
                
               /* $successMessage = $this->get('translator')->trans('El usuario ha sido creado.');
                $this->addFlash('mensaje', $successMessage);*/
                
                return $this->redirect('index');                
            }
            return $this->render('UCUsersBundle:Users:add.html.twig', array('form' => $form->createView()));

        }



      public function deleteAction(Request $request, $id)
    {
        $uc = $this->getDoctrine()->getManager();
        
        $user = $uc->getRepository('UCUsersBundle:Users')->find($id);
        
        if(!$user)
        {
            $messageException = $this->get('translator')->trans('User not found.');
            throw $this->createNotFoundException($messageException);
        }
        
        $allUsers = $uc->getRepository('UCUsersBundle:Users')->findAll();
        $countUsers = count($allUsers);
        
        // $form = $this->createDeleteForm($user);
        $form = $this->createCustomForm($user->getId(), 'DELETE', 'uc_users_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res = $this->deleteUser($uc, $user);
                
                return new Response(
                    json_encode(array('removed' => $res['removed'], 'message' => $res['message'], 'countUsers' => $countUsers)),
                    200,
                    array('Content-Type' => 'application/json')
                );
            }
            
            $res = $this->deleteUser($uc, $user);
            $this->get('session')->getFlashBag()->add($res['status'], $res['message']);
            return $this->redirect('index');            
        }
    }


        private function deleteUser($uc, $user)
    {
 
            $uc->remove($user);
            $uc->flush();
            $removed = 1;
            $alert = 'mensaje';

         if ($flush == null) {
         	$status = 'success';
            $message = 'El usuario ha sido eliminado.';
        } else {
        	$status = 'danger';
            $message = 'No se pudo eliminar el usuario.';
        }
        
        return array('status' => $status, 'removed' => $removed, 'message' => $message, 'alert' => $alert);
    }

    private function createCustomForm($id, $method, $route)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod($method)
            ->getForm();
    }
        
        
    }