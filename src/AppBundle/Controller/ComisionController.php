<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comision;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comision controller.
 *
 * @Route("comision")
 */
class ComisionController extends Controller
{
    /**
     * Lists all comision entities.
     *
     * @Route("/", name="comision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comisions = $em->getRepository('AppBundle:Comision')->findAll();

        return $this->render('comision/index.html.twig', array(
            'comisions' => $comisions,
        ));
    }

    /**
     * Creates a new comision entity.
     *
     * @Route("/new", name="comision_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $comision = new Comision();
        $form = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comision);
            $em->flush();

            return $this->redirectToRoute('comision_show', array('idcomision' => $comision->getIdcomision()));
        }

        return $this->render('comision/new.html.twig', array(
            'comision' => $comision,
            'form' => $form->createView(),
        ));
    }
    
    
       /**
     * Show all comision entities.
     *
     * @Route("/filtrar", name="comision_filtrar")
     * @Method({"GET", "POST"})
     */
    
    public function filtrarAction(Request $request)
    {
       $comision = new Comision();
       $form = $this->createForm('AppBundle\Form\ComisionType_1', $comision);
       $form->handleRequest($request);
       
       $em = $this->getDoctrine()->getManager();
       $comisions = $em->getRepository('AppBundle:Comision')->findBy(array(
               'materiamateria'=>$comision->getMateriamateria(),
               'year'=>$comision->getYear()
               ));
       $horarios=array();
       foreach($comisions as $comision){
           $horario= $em->getRepository('AppBundle:Horario')->findBycomisioncomision(
                   $comision->getIdcomision()   
           );
           $horarios[]=$horario;
       }
       //por cada comision tengo que buscar todos los horarios que contengan esa comision y guardarlas en horarios
       //podria crear un arreglo que contenga una comision y sus horarios y con un if solucionar el tema de muchos horarios
       
       //recorrer todas las comisiones y por cada una agregar a un arreglo grande un arreglo de la comision mas sus horarios  
             
           
    
        return $this->render('comision/filtrar.html.twig', array(
            'comisions' => $comisions,
            'horarios' => $horarios,
            'form' => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a comision entity.
     *
     * @Route("/{idcomision}", name="comision_show")
     * @Method("GET")
     */
    public function showAction(Comision $comision)
    {
        $deleteForm = $this->createDeleteForm($comision);

        return $this->render('comision/show.html.twig', array(
            'comision' => $comision,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing comision entity.
     *
     * @Route("/{idcomision}/edit", name="comision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comision $comision)
    {
        $deleteForm = $this->createDeleteForm($comision);
        $editForm = $this->createForm('AppBundle\Form\ComisionType', $comision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comision_edit', array('idcomision' => $comision->getIdcomision()));
        }

        return $this->render('comision/edit.html.twig', array(
            'comision' => $comision,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comision entity.
     *
     * @Route("/{idcomision}", name="comision_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comision $comision)
    {
        $form = $this->createDeleteForm($comision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comision);
            $em->flush();
        }

        return $this->redirectToRoute('comision_index');
    }

    /**
     * Creates a form to delete a comision entity.
     *
     * @param Comision $comision The comision entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comision $comision)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comision_delete', array('idcomision' => $comision->getIdcomision())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
