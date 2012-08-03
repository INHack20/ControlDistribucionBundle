<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\TribunalTipo;
use INHack20\ControlDistribucionBundle\Form\TribunalTipoType;

/**
 * TribunalTipo controller.
 *
 * @Route("/configuracion/tribunaltipo")
 */
class TribunalTipoController extends Controller
{
    /**
     * Lists all TribunalTipo entities.
     *
     * @Route("/", name="tribunaltipo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a TribunalTipo entity.
     *
     * @Route("/{id}/show", name="tribunaltipo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TribunalTipo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TribunalTipo entity.
     *
     * @Route("/new", name="tribunaltipo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TribunalTipo();
        $form   = $this->createForm(new TribunalTipoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TribunalTipo entity.
     *
     * @Route("/create", name="tribunaltipo_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:TribunalTipo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new TribunalTipo();
        $request = $this->getRequest();
        $form    = $this->createForm(new TribunalTipoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tribunaltipo_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errors' => $this->container->getParameter('FALLO_REGISTRO'),
        );
    }

    /**
     * Displays a form to edit an existing TribunalTipo entity.
     *
     * @Route("/{id}/edit", name="tribunaltipo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TribunalTipo entity.');
        }

        $editForm = $this->createForm(new TribunalTipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errors' => $this->getRequest()->query->get('errors'),
        );
    }

    /**
     * Edits an existing TribunalTipo entity.
     *
     * @Route("/{id}/update", name="tribunaltipo_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:TribunalTipo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TribunalTipo entity.');
        }

        $editForm   = $this->createForm(new TribunalTipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tribunaltipo_edit', array('id' => $id,
                'errors' => $this->container->getParameter('EXITO_ACTUALIZACION'),)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errors' => $this->container->getParameter('FALLO_ACTUALIZACION'),
        );
    }

    /**
     * Deletes a TribunalTipo entity.
     *
     * @Route("/{id}/delete", name="tribunaltipo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TribunalTipo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tribunaltipo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
