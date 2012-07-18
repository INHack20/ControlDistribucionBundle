<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Horario;
use INHack20\ControlDistribucionBundle\Form\HorarioType;

/**
 * Horario controller.
 *
 * @Route("/horario")
 */
class HorarioController extends Controller
{
    /**
     * Lists all Horario entities.
     *
     * @Route("/", name="horario")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:Horario')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Horario entity.
     *
     * @Route("/{id}/show", name="horario_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Horario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Horario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Horario entity.
     *
     * @Route("/new", name="horario_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Horario();
        $form   = $this->createForm(new HorarioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Horario entity.
     *
     * @Route("/create", name="horario_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Horario:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Horario();
        $request = $this->getRequest();
        $form    = $this->createForm(new HorarioType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('horario_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Horario entity.
     *
     * @Route("/{id}/edit", name="horario_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Horario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Horario entity.');
        }

        $editForm = $this->createForm(new HorarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Horario entity.
     *
     * @Route("/{id}/update", name="horario_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Horario:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Horario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Horario entity.');
        }

        $editForm   = $this->createForm(new HorarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('horario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Horario entity.
     *
     * @Route("/{id}/delete", name="horario_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:Horario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Horario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('horario'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
