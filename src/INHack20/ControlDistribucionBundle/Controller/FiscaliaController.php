<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Fiscalia;
use INHack20\ControlDistribucionBundle\Form\FiscaliaType;

/**
 * Fiscalia controller.
 *
 * @Route("/fiscalia")
 */
class FiscaliaController extends Controller
{
    /**
     * Lists all Fiscalia entities.
     *
     * @Route("/", name="fiscalia")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:Fiscalia')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Fiscalia entity.
     *
     * @Route("/{id}/show", name="fiscalia_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Fiscalia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiscalia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Fiscalia entity.
     *
     * @Route("/new", name="fiscalia_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fiscalia();
        $form   = $this->createForm(new FiscaliaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Fiscalia entity.
     *
     * @Route("/create", name="fiscalia_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Fiscalia:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Fiscalia();
        $request = $this->getRequest();
        $form    = $this->createForm(new FiscaliaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fiscalia_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Fiscalia entity.
     *
     * @Route("/{id}/edit", name="fiscalia_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Fiscalia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiscalia entity.');
        }

        $editForm = $this->createForm(new FiscaliaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Fiscalia entity.
     *
     * @Route("/{id}/update", name="fiscalia_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Fiscalia:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Fiscalia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiscalia entity.');
        }

        $editForm   = $this->createForm(new FiscaliaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fiscalia_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Fiscalia entity.
     *
     * @Route("/{id}/delete", name="fiscalia_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:Fiscalia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fiscalia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fiscalia'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
