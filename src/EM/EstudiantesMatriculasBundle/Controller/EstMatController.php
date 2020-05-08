<?php

namespace EM\EstudiantesMatriculasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EM\EstudiantesMatriculasBundle\Entity\Estudiantes;
use Symfony\Component\Form\FormError;
use EM\EstudiantesMatriculasBundle\Entity\Matriculas;
use EM\EstudiantesMatriculasBundle\Form\EstudiantesType;
use EM\EstudiantesMatriculasBundle\Form\MatriculasType;


class EstMatController extends Controller
{
    public function indexAction()
    {
    	$mat = new Matriculas();
        $form = $this->createCreateForm($mat);
        $em = $this->getDoctrine()->getManager();
        $matricula = $em->getRepository('EMEstudiantesMatriculasBundle:Matriculas')->findAll();
 

       $deleteFormAjax = $this->createCustomForm(':MATEST_ID', 'DELETE', 'em_estudiantes_matriculas_deletemat');
        return $this->render('EMEstudiantesMatriculasBundle:Matriculas:index.html.twig', array('delete_form_ajax' => $deleteFormAjax,'matricula' => $matricula,'form' => $form->createView(),'formdelete' => $deleteFormAjax->createView()));

 
    }


    public function eindexAction()
    {

        $est = new Estudiantes();
        $form = $this->createCreateFormEst($est);
        $em = $this->getDoctrine()->getManager();
        $estudiante = $em->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->findAll();
        $deleteFormAjax = $this->createCustomForm(':MATEST_ID', 'DELETE', 'em_estudiantes_matriculas_delete');

        return $this->render('EMEstudiantesMatriculasBundle:Estudiantes:index.html.twig', array('delete_form_ajax' => $deleteFormAjax,'estudiante' => $estudiante,'form' => $form->createView(),'formdelete' => $deleteFormAjax->createView()));
    }

    public function editAction($id){

        $em = $this->getDoctrine()->getManager();
        $estudiante = $em->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->find($id);
        
        if(!$estudiante)
        {
            $messageException = $this->get('translator')->trans('estudiante not found.');
            throw $this->createNotFoundException($messageException);
        }
        
        $form = $this->createEditForm($estudiante);
        
        return $this->render('EMEstudiantesMatriculasBundle:Estudiantes:edit.html.twig', array('estudiante' => $estudiante, 'form' => $form->createView()));

    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $estudiante = $em->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->find($id);

        if(!$estudiante)
        {
            $messageException = $this->get('translator')->trans('Student not found.');
            throw $this->createNotFoundException($messageException);
        }
        
        $form = $this->createEditForm($estudiante);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El estudiante se ha modificado.');
             
                    return $this->render('EMEstudiantesMatriculasBundle:Estudiantes:edit.html.twig', array('id' => $estudiante->getId(),'estudiante' => $estudiante, 'form' => $form->createView()));
    
        }

        return $this->render('EMEstudiantesMatriculasBundle:Estudiantes:edit.html.twig', array('estudiante' => $estudiante, 'form' => $form->createView()));
    }

    private function createEditForm(Estudiantes $entity)
    {
        $form = $this->createForm(new EstudiantesType(), $entity, array('action' => $this->generateUrl('em_estudiantes_matriculas_update', array('id' => $entity->getId())), 'method' => 'PUT'));
        
        return $form;
    }

    private function createCreateFormEst(Estudiantes $entity)
    {
        $form = $this->createForm(new EstudiantesType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('em_estudiantes_matriculas_createest'),
            'method' => 'POST'
        ));
        
        return $form;
    }

    private function createCreateForm(Matriculas $entity)
    {
        $form = $this->createForm(new MatriculasType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('em_estudiantes_matriculas_createmat'),
            'method' => 'POST'
        ));
        
        return $form;
    }

    public function createestAction(Request $request)
    { 
        $est = new Estudiantes();
        $form = $this->createCreateFormEst($est);
        $form->handleRequest($request);
  
        
        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($est);
            $em->flush();
              
            $this->get('session')->getFlashBag()->add('success', 'El estudiante fue creado con éxito.');          
            
            return $this->redirect('eindex'); 
        }

        $em = $this->getDoctrine()->getManager();
        $estudiante = $em->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->findAll();
        $deleteFormAjax = $this->createCustomForm(':MATEST_ID', 'DELETE', 'em_estudiantes_matriculas_delete');

        return $this->render('EMEstudiantesMatriculasBundle:Estudiantes:index.html.twig', array('delete_form_ajax' => $deleteFormAjax,'estudiante' => $estudiante,'form' => $form->createView(),'formdelete' => $deleteFormAjax->createView()));
 
    }

    public function creatematAction(Request $request)
    { 
    	$mat = new Matriculas();
        $form = $this->createCreateForm($mat);
        $form->handleRequest($request);
  
        
        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mat);
            $em->flush();
              
            $this->get('session')->getFlashBag()->add('success', 'La matricula fue creada con éxito.');          
            
            return $this->redirect('index'); 
        }
            $em = $this->getDoctrine()->getManager();
            $matricula = $em->getRepository('EMEstudiantesMatriculasBundle:Matriculas')->findAll();
            $es = $this->getDoctrine()->getManager();
            $estudiante = $es->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->findAll();
            $deleteFormAjax = $this->createCustomForm(':MATEST_ID', 'DELETE', 'em_estudiantes_matriculas_deletemat');

        return $this->render('EMEstudiantesMatriculasBundle:Matriculas:index.html.twig', array('delete_form_ajax' => $deleteFormAjax,'matricula' => $matricula,'estudiante' => $estudiante,'form' => $form->createView(),'formdelete' => $deleteFormAjax->createView()));
 
    }


    public function deletematAction(Request $request, $id)
    {
        $mat = $this->getDoctrine()->getManager();
        
        $matricula = $mat->getRepository('EMEstudiantesMatriculasBundle:Matriculas')->find($id);
        
        if(!$matricula)
        {
            $messageException = $this->get('translator')->trans('User not found.');
            throw $this->createNotFoundException($messageException);
        }
        
        $allmat = $mat->getRepository('EMEstudiantesMatriculasBundle:Matriculas')->findAll();
        $countMat = count($allmat);
        
        // $form = $this->createDeleteForm($matricula);
        $form = $this->createCustomForm($matricula->getId(), 'DELETE', 'em_estudiantes_matriculas_deletemat');
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res = $this->deleteMat($mat, $matricula);
                
                return new Response(
                    json_encode(array('removed' => $res['removed'], 'message' => $res['message'], 'countMat' => $countMat)),
                    200,
                    array('Content-Type' => 'application/json')
                );
            }
            
            $res = $this->deleteMat($mat, $matricula);
            $this->get('session')->getFlashBag()->add($res['status'], $res['message']);
            return $this->redirect('index');            
        }
    }

    
    public function deleteAction(Request $request, $id)
    {
        $est = $this->getDoctrine()->getManager();
        $estudiante = $est->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->find($id);
        
        if(!$estudiante)
        {
            $messageException = $this->get('translator')->trans('User not found.');
            throw $this->createNotFoundException($messageException);
        }
        
        $allest = $est->getRepository('EMEstudiantesMatriculasBundle:Estudiantes')->findAll();
        $countEst = count($allest);
        
        // $form = $this->createDeleteForm($estudiante);
        $form = $this->createCustomForm($estudiante->getId(), 'DELETE', 'em_estudiantes_matriculas_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res = $this->deleteEst($est, $estudiante);
                
                return new Response(
                    json_encode(array('removed' => $res['removed'], 'message' => $res['message'], 'countEst' => $countEst)),
                    200,
                    array('Content-Type' => 'application/json')
                );
            }
             
            $res = $this->deleteEst($mat, $estudiante);
            $this->get('session')->getFlashBag()->add($res['status'], $res['message']);
            return $this->redirect('index');            
        }
    }

    private function deleteEst($uc, $est)
    {
            $uc->remove($est);
            $uc->flush();
            $removed = 1;
            $alert = 'mensaje';

         if ($flush == null) {
            $status = 'success';
            $message = 'El estudiante ha sido eliminado.';
        } else {
            $status = 'danger';
            $message = 'El estudiante no pudo ser eliminado.';
        }
        
        return array('status' => $status, 'removed' => $removed, 'message' => $message, 'alert' => $alert);
    }

    private function deleteMat($uc, $mat)
    {
           $uc->remove($mat);
            $uc->flush();
            $removed = 1;
            $alert = 'mensaje';

         if ($flush == null) {
            $status = 'success';
            $message = 'La matricula ha sido eliminada.';
        } else {
            $status = 'danger';
            $message = 'La matricula no pudo ser eliminada.';
        }
        
        return array('status' => $status, 'removed' => $removed, 'message' => $message, 'alert' => $alert);
    }

    public function viewmatAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('EMEstudiantesMatriculasBundle:Matriculas');
        
        $matricula = $repository->find($id);
        
        if(!$matricula)
        {
            $messageException = $this->get('translator')->trans('matricula not found.');
            throw $this->createNotFoundException($messageException);
        }
        
        $deleteForm = $this->createCustomForm($matricula->getId(), 'DELETE', 'em_estudiantes_matriculas_deletemat');
        
        return $this->render('EMEstudiantesMatriculasBundle:Matriculas:view.html.twig', array('user' => $user, 'delete_form' => $deleteForm->createView()));
    }

    private function createCustomForm($id, $method, $route)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod($method)
            ->getForm();
    }

}
