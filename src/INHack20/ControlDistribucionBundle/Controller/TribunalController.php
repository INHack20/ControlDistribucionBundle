<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Tribunal;
use INHack20\ControlDistribucionBundle\Form\TribunalType;

/**
 * Tribunal controller.
 *
 * @Route("/configuracion/tribunal")
 */
class TribunalController extends Controller
{
    /**
     * Lists all Tribunal entities.
     *
     * @Route("/", name="tribunal")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:Tribunal')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Tribunal entity.
     *
     * @Route("/{id}/show", name="tribunal_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Tribunal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tribunal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'status' => $this->getRequest()->query->get('status'),
            );
    }

    /**
     * Displays a form to create a new Tribunal entity.
     *
     * @Route("/new", name="tribunal_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tribunal();
        $entity->setHabilitado(true);
        $form   = $this->createForm(new TribunalType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Tribunal entity.
     *
     * @Route("/create", name="tribunal_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Tribunal:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Tribunal();
        $request = $this->getRequest();
        $form    = $this->createForm(new TribunalType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setHabilitado(true);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tribunal_show', array('id' => $entity->getId(),
                'status' => $this->container->getParameter('EXITO_REGISTRO'),)));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'status' => $this->container->getParameter('FALLO_REGISTRO'),
        );
    }

    /**
     * Displays a form to edit an existing Tribunal entity.
     *
     * @Route("/{id}/edit", name="tribunal_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Tribunal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tribunal entity.');
        }

        $editForm = $this->createForm(new TribunalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'status' => $this->getRequest()->query->get('status'),
        );
    }

    /**
     * Edits an existing Tribunal entity.
     *
     * @Route("/{id}/update", name="tribunal_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Tribunal:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Tribunal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tribunal entity.');
        }

        $editForm   = $this->createForm(new TribunalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tribunal_edit', array(
                'id' => $id,
                'status' => $this->container->getParameter('EXITO_ACTUALIZACION'),)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'status' => $this->container->getParameter('FALLO_ACTUALIZACION'),
        );
    }

    /**
     * Deletes a Tribunal entity.
     *
     * @Route("/{id}/delete", name="tribunal_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:Tribunal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tribunal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tribunal'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
