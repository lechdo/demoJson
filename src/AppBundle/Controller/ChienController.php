<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Chien controller.
 *
 * @Route("chien")
 */
class ChienController extends Controller
{
    /**
     * Lists all chien entities.
     *
     * @Route("/", name="chien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chiens = $em->getRepository('AppBundle:Chien')->findAll();

        return $this->render('chien/index.html.twig', array(
            'chiens' => $chiens,
        ));
    }

    /**
     * Creates a new chien entity.
     *
     * @Route("/new", name="chien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $chien = new Chien();
        $form = $this->createForm('AppBundle\Form\ChienType', $chien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chien);
            $em->flush();

            return $this->redirectToRoute('chien_show', array('id' => $chien->getId()));
        }

        return $this->render('chien/new.html.twig', array(
            'chien' => $chien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chien entity.
     *
     * @Route("/{id}", name="chien_show")
     * @Method("GET")
     */
    public function showAction(Chien $chien)
    {
        $deleteForm = $this->createDeleteForm($chien);

        return $this->render('chien/show.html.twig', array(
            'chien' => $chien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chien entity.
     *
     * @Route("/{id}/edit", name="chien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chien $chien)
    {
        $deleteForm = $this->createDeleteForm($chien);
        $editForm = $this->createForm('AppBundle\Form\ChienType', $chien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chien_edit', array('id' => $chien->getId()));
        }

        return $this->render('chien/edit.html.twig', array(
            'chien' => $chien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chien entity.
     *
     * @Route("/{id}", name="chien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chien $chien)
    {
        $form = $this->createDeleteForm($chien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chien);
            $em->flush();
        }

        return $this->redirectToRoute('chien_index');
    }

    /**
     * Creates a form to delete a chien entity.
     *
     * @param Chien $chien The chien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chien $chien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chien_delete', array('id' => $chien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
