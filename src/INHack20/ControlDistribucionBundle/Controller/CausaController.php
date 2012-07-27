<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Causa;
use INHack20\ControlDistribucionBundle\Form\CausaType;

/**
 * Causa controller.
 *
 * @Route("/config/causa")
 */
class CausaController extends Controller
{
    /**
     * Lists all Causa entities.
     *
     * @Route("/", name="causa")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Causa entity.
     *
     * @Route("/{id}/show", name="causa_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Causa entity.
     *
     * @Route("/new", name="causa_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Causa();
        $form   = $this->createForm(new CausaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Causa entity.
     *
     * @Route("/create", name="causa_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Causa:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Causa();
        $request = $this->getRequest();
        $form    = $this->createForm(new CausaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('causa_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Causa entity.
     *
     * @Route("/{id}/edit", name="causa_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }

        $editForm = $this->createForm(new CausaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Causa entity.
     *
     * @Route("/{id}/update", name="causa_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Causa:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }

        $editForm   = $this->createForm(new CausaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('causa_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Causa entity.
     *
     * @Route("/{id}/delete", name="causa_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Causa entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('causa'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
