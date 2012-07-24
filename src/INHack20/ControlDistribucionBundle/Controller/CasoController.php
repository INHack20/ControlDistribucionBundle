<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Caso;
use INHack20\ControlDistribucionBundle\Form\CasoType;
use INHack20\ControlDistribucionBundle\TCPDF\Caso\Resumen;
use INHack20\ControlDistribucionBundle\Entity\Distribucion;

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
     * @Route("/{idCausa}/new", name="caso_new")
     * @Template()
     */
    public function newAction($idCausa)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $causa = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($idCausa);
        
        if (!$causa) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }
        
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        
        $entity = new Caso();
        
        $form   = $this->createForm(new CasoType($usuario->getEstado()), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'causa' => $causa,
        );
    }

    /**
     * Creates a new Caso entity.
     *
     * @Route("/{idCausa}/create", name="caso_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Caso:new.html.twig")
     */
    public function createAction($idCausa)
    {
        $erroesDistribucion = array();
        $em = $this->getDoctrine()->getEntityManager();
        $causa = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($idCausa);
        
        if (!$causa) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        
        $entity  = new Caso();
        $request = $this->getRequest();
        $form    = $this->createForm(new CasoType($usuario->getEstado()), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            
            $distribucion = new Distribucion($em);
            
            if(!$distribucion->distribuir($causa))
            {
                $erroesDistribucion = $distribucion->getErrores();
            }
            else{
                 $entity->setDistribucion($distribucion);
                 $entity->setUsuario($this->container->get('security.context')->getToken()->getUser());
                 $em = $this->getDoctrine()->getEntityManager();
                 $em->persist($entity);
                 $em->flush();

                 return $this->redirect($this->generateUrl('caso_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'causa' => $causa,
            'erroesDistribucion' => $erroesDistribucion,
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
        
        $editForm = $this->createForm(new CasoType($entity->getFiscalia()->getEstado()), $entity);
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

        $editForm   = $this->createForm(new CasoType($entity->getFiscalia()->getEstado()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('caso_show', array('id' => $id)));
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
    
    /**
     * @Route("/resumen", name="caso_resumen") 
     * @Template()
     */
    public function resumenAction(){
        $request = $this->getRequest();
        
        $form = $this->createResumenForm();
        
        if($request->getMethod()=='POST'){
            $form->bindRequest($request);
            if($form->isValid()){
                // create new PDF document
                
                $datos = $form->getData();
                
                $pdf = new Resumen('L', 'mm', 'A4', true, 'UTF-8', false);

                $pdf->setLogo($this->getAssetUrl('bundles/inhack20controldistribucion/images/escudo.jpeg'));
                $pdf->setFecha($datos['fecha']->format('d-m-Y'));
                
                // set document information
                $pdf->SetCreator('TCPDF');
                $pdf->SetAuthor('Ing. Carlos Mendoza');
                $pdf->SetTitle('Comprobante de recepcion de asunto nuevo');
                $pdf->SetSubject('TCPDF Tutorial');
                $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                // set default header data
                $pdf->SetHeaderData('tcpdf_logo.jpg', 30, 'EJEMPLO', 'POR MENDOZA CARLOS');

                // set header and footer fonts
                $pdf->setHeaderFont(Array('helvetica', '', 10));
                $pdf->setFooterFont(Array('helvetica', '', 8));

                // set default monospaced font
                $pdf->SetDefaultMonospacedFont('courier');
                $pdf->SetFont('helvetica', '', 10);


                //set margins
                $PDF_MARGIN_LEFT = 15;
                $PDF_MARGIN_TOP = 85;
                $PDF_MARGIN_RIGHT = 15;
                $PDF_MARGIN_HEADER = 15;
                $PDF_MARGIN_FOOTER = 25;
                $pdf->SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin($PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin($PDF_MARGIN_FOOTER);

                $PDF_MARGIN_BOTTOM = 25;
                //set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, $PDF_MARGIN_BOTTOM);



                $pdf->AddPage();

                $html='
                    <table style="text-align: center; width: 100%;" border="1" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="vertical-align: top;">Fecha<br></td>
                                <td style="vertical-align: top;">Hora<br></td>
                                <td style="vertical-align: top;">N° Oficio<br></td>
                                <td style="vertical-align: top;">N° Asunto Fiscal<br></td>
                                <td style="vertical-align: top;">Imputado<br></td>
                                <td style="vertical-align: top;">Victima<br></td>
                                <td style="vertical-align: top;">Tribunal<br></td>
                            </tr>
                       ';
                 $html.='
                            <tr>
                                <td style="vertical-align: top;">_fecha<br></td>
                                <td style="vertical-align: top;">_hora<br></td>
                                <td style="vertical-align: top;">_n_oficio<br></td>
                                <td style="vertical-align: top;">_asunto_fiscal<br></td>
                                <td style="vertical-align: top;">_imputado<br></td>
                                <td style="vertical-align: top;">_victima<br></td>
                                <td style="vertical-align: top;">_tribunal<br></td>
                            </tr>
                        ';
                 
                $html.='</tbody>
                    </table>
                    ';
                
                $pdf->writeHTML($html, true, false, true, false, '');
                
                return $pdf->Output('resumen.pdf');
                }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    private function createResumenForm(){
        $fecha = new \DateTime();
        return $this->createFormBuilder(array('fecha',$fecha))
            ->add('fecha','date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'invalid_message' => 'Debe ingresar una fecha valida. ( Ejemplo '.$fecha->format('d-m-Y').')',
                
            ))
            ->getForm()
            ;
    }
    
    /**
     * Genera el comprobante de un caso luego de hacer la distribucion del tribunal
     * @Route("/{idCaso}/comprobante", name="caso_comprobante")
     */
    public function comprobanteAction($idCaso){
        $em = $this->getDoctrine()->getEntityManager();
        
        $caso = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($idCaso);
        
        if(!$caso){
            throw $this->createNotFoundException('No se ha encontrado la entidad Caso');
        }
        
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        
        // create new PDF document
        $pdf = new \INHack20\ControlDistribucionBundle\TCPDF\Caso\Comprobante('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->setLogo($this->getAssetUrl('bundles/inhack20controldistribucion/images/escudo.jpeg'));
        
        $pdf->setNroControlInterno($caso->getId());
        $pdf->setNombre($usuario->getNombre());
        $pdf->setCargo($usuario->getCargo());
        
        // set document information
        $pdf->SetCreator('TCPDF');
        $pdf->SetAuthor('Ing. Carlos Mendoza');
        $pdf->SetTitle('Comprobante de recepcion de asunto nuevo');
        $pdf->SetSubject('Comprobante de recepcion de asunto');
        $pdf->SetKeywords('Comprobante, Distribucion');

        // set default header data
        //$pdf->SetHeaderData('tcpdf_logo.jpg', 30, 'EJEMPLO', 'POR MENDOZA CARLOS');

        // set header and footer fonts
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 8));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont('courier');
        $pdf->SetFont('helvetica', '', 12);
        

        //set margins
        $PDF_MARGIN_LEFT = 15;
        $PDF_MARGIN_TOP = 110;
        $PDF_MARGIN_RIGHT = 15;
        $PDF_MARGIN_HEADER = 15;
        $PDF_MARGIN_FOOTER = 25;
        $pdf->SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin($PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin($PDF_MARGIN_FOOTER);
        
        $PDF_MARGIN_BOTTOM = 25;
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, $PDF_MARGIN_BOTTOM);
        
        $pdf->AddPage();
        
        $html='
                <p style="margin-bottom: 0cm;" align="center">
                    <u>
                        <b>COMPROBANTE DE RECEPCIÓN DE UN ASUNTO NUEVO</b>
                     </u>
                </p>
                <p style="margin-bottom: 0cm; text-decoration: none;" align="center"><br></p>
                
                <p style="margin-bottom: 0cm; line-height: 2" align="justify">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    En la Unidad de Recepción y Distribución de Documentos del Circuito Judicial Penal del Edo.
                    Apure en la fecha de hoy 
                    <b>'.$caso->getCreado()->format('d-m-Y').'</b>
                    siendo las <b>'.$caso->getCreado()->format('h:i A').',</b>
                    se recibió la solicitud de
                    <b>'.$caso->getDistribucion()->getCausa()->getNombre()  .',</b>
                    constante
                    <b>('.$caso->getPieza().')</b>
                    pieza, Emanada de la
                    <b>'.$caso->getFiscalia()->getNombre().'</b>
                    del Ministerio Público, relacionado con el asunto Fiscal N°
                    <b>'.$caso->getNroAsuntoFiscal().'</b>,
                     seguido al imputado:
                    <b>'.$caso->getNombreImputado().',</b>
                     por la presunta comisiona de un delito en perjuicio de la víctima
                    <b>'.$caso->getNombreVictima().'.</b></p>
        
            ';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf->Output();
    }
    
    private function getAssetUrl($path, $packageName = null)
    {
        return $this->container->get('templating.helper.assets')->getUrl($path, $packageName);
    }
}
