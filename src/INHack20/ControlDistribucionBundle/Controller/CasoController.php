<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Caso;
use INHack20\ControlDistribucionBundle\Form\CasoType;

/**
 * Caso controller.
 *
 * @Route("/caso")
 */
class CasoController extends Controller
{
    /**
     * Lists all Caso entities.
     *
     * @Route("/", name="caso")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Caso entity.
     *
     * @Route("/{id}/show", name="caso_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Caso entity.
     *
     * @Route("/new", name="caso_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Caso();
        $form   = $this->createForm(new CasoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Caso entity.
     *
     * @Route("/create", name="caso_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Caso:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Caso();
        $request = $this->getRequest();
        $form    = $this->createForm(new CasoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('caso_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Caso entity.
     *
     * @Route("/{id}/edit", name="caso_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caso entity.');
        }

        $editForm = $this->createForm(new CasoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Caso entity.
     *
     * @Route("/{id}/update", name="caso_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Caso:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caso entity.');
        }

        $editForm   = $this->createForm(new CasoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('caso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Caso entity.
     *
     * @Route("/{id}/delete", name="caso_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Caso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('caso'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
