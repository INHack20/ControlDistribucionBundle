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
use MakerLabs\PagerBundle\Pager;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
     * @Route("/{page}", name="caso", requirements={"page" = "\d+"}, defaults={"page" = "1"}, options={"expose" = true})
     * @Template()
     */
    public function indexAction($page)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $qb = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->createQueryBuilder('c');
        
        $cargarFormulario = $request->query->get('form');
        $formBuscar = $this->createFormBuscar();
        
        $parametros = array();
            // Variables de busqueda por fechas
            $parametros['fecha'] = $request->query->get('fecha');
            $parametros['f_desde'] = $request->query->get('f_desde');
            $parametros['f_hasta'] = $request->query->get('f_hasta');
            
        // Variables de consulta por fechas
            if($parametros['fecha'] != '')
                $qb->andWhere($qb->expr()->like('c.creado', "'".$parametros['fecha']."%'"));
            
            if($parametros['f_desde'] != '' && $parametros['f_hasta'] != ''){
            $qb->where('c.creado >= :f_desde')
                    ->setParameter('f_desde', $parametros['f_desde'])
                    ;
            $qb->andWhere('c.creado <= :f_hasta')
                    ->setParameter('f_hasta', $parametros['f_hasta']. '23:59 59')
                    ;
            }//fin if    
        
        if($request->isXmlHttpRequest()){
            
            // Variables de busqueda desde formulario
            $parametros['tribunaltipo'] = $request->query->get('tribunaltipo');
            $parametros['id'] = $request->query->get('id');
            $parametros['tribunal'] = $request->query->get('tribunal');
            $parametros['causa'] = $request->query->get('causa');
            $parametros['nroAsuntoFiscal'] = $request->query->get('nroAsuntoFiscal');
            $parametros['nroOficioFiscal'] = $request->query->get('nroOficioFiscal');
            $parametros['nombreImputado'] = $request->query->get('nombreImputado');
            $parametros['nombreVictima'] = $request->query->get('nombreVictima');
            $parametros['acusacionPrivada'] = $request->query->get('acusacionPrivada');
            $parametros['horaInicio'] = $request->query->get('horaInicio');
            $parametros['horaFin'] = $request->query->get('horaFin');
            
            $formBuscar->bindRequest($request);
            if($formBuscar->isValid()){
               $data = $formBuscar->getData();
                    //$parametros['fecha'] = $data['fecha']!='' ? $data['fecha']->format('Y-m-d') : '';
                    $parametros['id'] = $data['id'];
                    $parametros['tribunaltipo'] = $data['tribunaltipo']!='' ? $data['tribunaltipo']->getId() : '';
                    $parametros['tribunal'] = $data['tribunal']!= '' ? $data['tribunal']->getId() : '';
                    $parametros['causa'] = $data['causa'] != '' ? $data['causa']->getId() : '';
                    $parametros['nroAsuntoFiscal'] = $data['nroAsuntoFiscal'];
                    $parametros['nroOficioFiscal'] = $data['nroOficioFiscal'];
                    $parametros['nombreImputado'] = $data['nombreImputado'];
                    $parametros['nombreVictima'] = $data['nombreVictima'];
                    $parametros['acusacionPrivada'] = $data['acusacionPrivada'];
                    $parametros['horaInicio'] = $data['horaInicio'];
                    $parametros['horaFin'] = $data['horaFin'];                   
               }
            // Creo la consulta de los datos del formulario
            $qb->join('c.distribucion','d');

            if($parametros['id']!='')
                $qb->andWhere ('d.id = :id')
                    ->setParameter('id', $parametros['id']);
            
            if($parametros['tribunal']!='')
                $qb->andWhere ('d.tribunal = :tribunal')
                    ->setParameter('tribunal', $parametros['tribunal']);

            if($parametros['tribunaltipo'] != ''){
                $qb->join('d.tribunal', 't');
                $qb->andWhere('t.tribunalTipo = :tribunaltipo')
                    ->setParameter('tribunaltipo',$parametros['tribunaltipo']);
            }
            
            if($parametros['causa'] != '')
                $qb->andWhere ('d.causa = :causa')
                    ->setParameter('causa', $parametros['causa']);
            
            if($parametros['nroAsuntoFiscal'] != '')
                $qb->andWhere ($qb->expr()->like('c.nroAsuntoFiscal', "'%".$parametros['nroAsuntoFiscal']."%'"));
            
            if($parametros['nroOficioFiscal'] != '')
                $qb->andWhere ($qb->expr()->like('c.nroOficioFiscal', "'%".$parametros['nroOficioFiscal']."%'"));
            
            if($parametros['nombreImputado'] != '')
                $qb->andWhere ($qb->expr()->like('c.nombreImputado', "'%".$parametros['nombreImputado']."%'"));
            
            if($parametros['nombreVictima'] != '')
                $qb->andWhere ($qb->expr()->like('c.nombreVictima', "'%".$parametros['nombreVictima']."%'"));
            
            if($parametros['acusacionPrivada'] != '')
                $qb->andWhere ('c.acusacionPrivada = :acusacionPrivada')
                ->setParameter('acusacionPrivada', $parametros['acusacionPrivada'])
                ;
            
            if($parametros['horaInicio'] != '')
                $qb->andWhere ('c.creado >= :horaInicio')
                ->setParameter('horaInicio', $parametros['horaInicio']);
            
            if($parametros['horaFin'] != '')
                $qb->andWhere ('c.creado <= :horaFin')
                ->setParameter('horaFin', $parametros['horaFin']);
        }
        
        $qb->orderBy('c.creado','desc');
        
        $adapter = new DoctrineOrmAdapter($qb);
        $paginador = new Pager($adapter, array('page' => $page,'limit' => $this->container->getParameter('LIMITE_PAGINACION')));
            
        if($request->isXmlHttpRequest())
        {
            return $this->render('INHack20ControlDistribucionBundle:Caso:lista.html.twig',array(
                'paginador' => $paginador,
                'parametros' => $parametros,
            ));
        }
        if($cargarFormulario)
            return array(
                'paginador' => $paginador,
                'formBuscar' => $formBuscar->createView(),
                );
        else
            return array(
                'paginador' => $paginador,
                'parametros' => $parametros,
                );
    }
    
    private function createFormBuscar(){
       
        return $this->createFormBuilder()
                ->add('fecha','date',array(
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'required' => false,
                    
                ))
                ->add('id',null,array(
                    'required' => false,
                    'label' => 'N&deg; Control Interno',
                ))
                ->add('tribunaltipo','entity',array(
                    'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\TribunalTipo',
                    'property' => 'nombre',
                    'empty_value' => 'Seleccione',
                    'required' => false,
                    'label' => 'Tipo de Tribunal',
                ))
                ->add('tribunal','entity',array(
                    'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Tribunal',
                    'property' => 'descripcion',
                    'empty_value' => 'Seleccione',
                    'required' => false,
                ))
                ->add('causa','entity',array(
                    'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Causa',
                    'property' => 'descripcion',
                    'empty_value' => 'Seleccione',
                    'required' => false,
                ))
                ->add('nroAsuntoFiscal',null,array(
                    'label' => 'N&deg; Causa',
                    'required' => false,
                ))
                ->add('nroOficioFiscal',null,array(
                    'label' => 'N&deg; Oficio',
                    'required' => false,
                ))
                ->add('nombreImputado',null,array(
                    'label' => 'Nombre del Imputado',
                    'required' => false,
                ))
                ->add('nombreVictima',null,array(
                    'label' => 'Nombre de la Victima',
                    'required' => false,
                ))
                ->add('acusacionPrivada','checkbox',array(
                    'label' => '¿Acusaci&oacute;n Privada?',
                    'required' => false,
                ))
                ->add('horaInicio','datetime',array(
                    'input' => 'string',
                    'widget' => 'single_text',
                    'label' => 'Desde(fecha,hora)',
                    'required' => false,
                ))
                ->add('horaFin','datetime',array(
                    'input' => 'string',
                    'widget' => 'single_text',
                    'label' => 'Hasta(fecha,hora)',
                    'required' => false,
                ))
                ->getForm()
                ;
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
     * @Route("/{idCausa}/new", name="caso_new", requirements={"idCaso" = "0"}, defaults={"idCaso" = "0"})
     * @Route("/{idCaso}/inhibicion/new", name="caso_new_inhibir", requirements={"idCausa" = "0"},defaults={"idCausa" = "0"})
     * @Template()
     * @Secure(roles="ROLE_SUPER_USER")
     */
    public function newAction($idCausa,$idCaso)
    {
        
        $parametros = array();
        $route = "";
        $em = $this->getDoctrine()->getEntityManager();
        if($idCausa != 0 ){
            $causa = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($idCausa);
            if (!$causa) {
                throw $this->createNotFoundException('Unable to find Causa entity.');
            }
            $parametros['idCausa'] = $causa->getId();
            $route = 'caso_create';
        }
        
        if($idCaso != 0)
        {
            $caso = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($idCaso);
            if (!$caso) {
                throw $this->createNotFoundException('Unable to find Caso entity.');
            }
            $causa = $caso->getDistribucion()->getCausa();
            $route = 'caso_create_inhibir';
            $parametros['idCaso'] = $caso->getId();
        }
        
        if($idCausa == 0 && $idCaso == 0){
            throw $this->createNotFoundException('No se ha recibido ninguna entidad valida Causa o Caso.');
        }
        
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        
        $entity = new Caso();
        
        if($idCaso != 0){
            $entity->setNombreImputado($caso->getNombreImputado());
            $entity->setNombreVictima($caso->getNombreVictima());
            $entity->setPieza($caso->getPieza());
        }
        
        $form   = $this->createForm(new CasoType($usuario->getEstado()), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'parametros' => $parametros,
            'causa' => $causa,
            'route' => $route,
        );
    }

    /**
     * Creates a new Caso entity.
     *
     * @Route("/{idCausa}/create", name="caso_create", requirements={"idCaso" = "0"}, defaults={"idCaso" = "0"})
     * @Route("/{idCaso}/inhibicion/create", name="caso_create_inhibir", requirements={"idCausa" = "0"}, defaults={"idCausa" = "0"})
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Caso:new.html.twig")
     * @Secure(roles="ROLE_SUPER_USER")
     */
    public function createAction($idCausa,$idCaso)
    {
        $parametros = array();
        $route = "";
        $erroesDistribucion = array();
        $em = $this->getDoctrine()->getEntityManager();
        $casoInhibicion = NULL;
        if($idCausa !=0 ){
            $causa = $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($idCausa);
            if (!$causa) {
                throw $this->createNotFoundException('Unable to find Causa entity.');
            }
            $parametros['idCausa'] = $causa->getId();
            $route = 'caso_create';
        }
        if($idCaso != 0){
            $casoInhibicion = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($idCaso);
            if(!$casoInhibicion){
                throw $this->createNotFoundException('No se ha encontrado la entidad Caso');
            }
            $causa = $casoInhibicion->getDistribucion()->getCausa();
            $route = 'caso_create_inhibir';
            $parametros['idCaso'] = $casoInhibicion->getId();
        }
        
        if($idCausa == 0 && $idCaso == 0){
            throw $this->createNotFoundException('No se ha recibido ninguna entidad valida Causa o Caso.');
        }
        
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        
        $entity  = new Caso();
        $request = $this->getRequest();
        $form    = $this->createForm(new CasoType($usuario->getEstado()), $entity);
        $form->bindRequest($request);
        
        if ($form->isValid()) {
            
            $distribucion = new Distribucion($em);
            
            if(!$distribucion->distribuir($causa,$casoInhibicion))
            {
                $erroesDistribucion = $distribucion->getErrores();
            }
            else{
                 if($casoInhibicion){
                    $entity->setInhibicion($casoInhibicion);
                    $em->persist($casoInhibicion);
                 }
                 
                 $entity->setDistribucion($distribucion);
                 $entity->setUsuario($this->container->get('security.context')->getToken()->getUser());
                 $em->persist($entity);
                 $em->flush();

                 return $this->redirect($this->generateUrl('caso_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'parametros' => $parametros,
            'causa' => $causa,
            'route' => $route,
            'erroesDistribucion' => $erroesDistribucion,
        );
    }

    /**
     * Displays a form to edit an existing Caso entity.
     *
     * @Route("/{id}/edit", name="caso_edit")
     * @Template()
     * @Secure(roles="ROLE_SUPER_USER")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caso entity.');
        }
        // Verificamos si el usuario tiene acceso a modificar todos los campos
        $read_only = true;
        if($this->get('security.context')->isGranted('ROLE_ADMIN')){
            $read_only = false;
        }
        if($entity->getFiscalia())
            $estado = $entity->getFiscalia()->getEstado();
        else
            $estado = $this->container->get('security.context')->getToken()->getUser()->getEstado();
        $editForm = $this->createForm(new CasoType($estado,$read_only),$entity);
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
     * @Secure(roles="ROLE_SUPER_USER")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caso entity.');
        }
        
        // Verificamos si el usuario tiene acceso a modificar todos los campos
        $read_only = true;
        if($this->get('security.context')->isGranted('ROLE_ADMIN')){
            $read_only = false;
        }
        if($entity->getFiscalia())
            $estado = $entity->getFiscalia()->getEstado();
        else
            $estado = $this->container->get('security.context')->getToken()->getUser()->getEstado();
        $editForm   = $this->createForm(new CasoType($estado,$read_only), $entity);
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
     * @Secure(roles="ROLE_ADMIN")
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
    
    /**
     * Se encarga de listar las causas que se procesan en un tipo de tribunal
     * @Route("/{id}/causas", name="caso_causas") 
     * @Template()
     */
    public function causasAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $tribunaltipo = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);
        if(!$tribunaltipo)
        {
            throw $this->createNotFoundException('No se ha encontrado la entidad TribunalTipo');
        }
        return array(
            'tribunalTipo' => $tribunaltipo,
        );
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
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
        $pdf->setNombre($usuario->getNombre().' '.$usuario->getApellido());
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
                    En la Unidad de Recepción y Distribución de Documentos del Circuito Judicial Penal de San Fernando de
                    Apure en la fecha de hoy 
                    <b>'.$caso->getCreado()->format('d-m-Y').', </b>
                    siendo las <b>'.$caso->getCreado()->format('h:i A').',</b>
                    se recibió la solicitud de
                    <b>'.$caso->getDistribucion()->getCausa()->getNombre()  .',</b>
                    constante de 
                    <b>('.$caso->getPieza().')</b>
                    pieza, Emanada ';
                    $procedencia = '<b>DESCONOCIDO';
                    if($caso->getFiscalia())
                            $procedencia = 'de la <b>'.$caso->getFiscalia()->getNombre() .' DEL MINISTERIO PUBLICO';
                        elseif($caso->getProcedenciaTribunal())
                            $procedencia = 'del <b>TRIBUNAL '.strtoupper($caso->getProcedenciaTribunal()->getDescripcion());
                    $html.= $procedencia.'</b>,
                    relacionado con la Causa N°
                    <b>'.$caso->getNroAsuntoFiscal().'</b>,
                     seguido al imputado:
                    <b>'.strtoupper($caso->getNombreImputado()).',</b>
                     por la presunta comisión de un delito en perjuicio de la víctima:
                    <b>'.strtoupper($caso->getNombreVictima()).',</b>
                     el cual por distribución aleatoria fue asignado al <b>TRIBUNAL
                     '.strtoupper($caso->getDistribucion()->getTribunal()->getDescripcion()).'</b>.
                    </p>
        
            ';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf->Output();
    }
    
    /**
     * Genera el comprobante de un caso luego de hacer la distribucion del tribunal
     * @Route("/resumen", name="caso_resumen")
     */
    public function resumenAction(){
        $request = $this->getRequest();
        
        $parametros = array();
        $parametros['fecha'] = $request->query->get('fecha');
        $parametros['f_desde'] = $request->query->get('f_desde');
        $parametros['f_hasta'] = $request->query->get('f_hasta');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $qb = $em->getRepository('INHack20ControlDistribucionBundle:Caso')->createQueryBuilder('c');
        
        $html = '';
        if($parametros['fecha']!=''){
            $qb->andWhere ($qb->expr()->like('c.creado', "'".$parametros['fecha']."%'"));
            $fecha = new \DateTime($parametros['fecha']);
            $html .= '<b>Resumen de Casos: Fecha '.$fecha->format('d-m-Y').'.</b>';
            $html.="<br/><br/>";
        }
        
        if($parametros['f_desde'] != '' && $parametros['f_hasta'] != ''){
            $qb->where('c.creado >= :f_desde')
                    ->setParameter('f_desde', $parametros['f_desde'])
                    ;
            $qb->andWhere('c.creado <= :f_hasta')
                    ->setParameter('f_hasta', $parametros['f_hasta']. '23:59 59')
                    ;
            $f_desde = new \DateTime($parametros['f_desde']);
            $f_hasta = new \DateTime($parametros['f_hasta']);
            $html .= '<b>Resumen de Casos: Desde '.$f_desde->format('d-m-Y').' hasta '.$f_hasta->format('d-m-Y').'.</b>';
            $html.="<br/><br/>";
        }//fin if
        
            // Variables de busqueda desde formulario
            $parametros['tribunaltipo'] = $request->query->get('tribunaltipo');
            $parametros['id'] = $request->query->get('id');
            $parametros['tribunal'] = $request->query->get('tribunal');
            $parametros['causa'] = $request->query->get('causa');
            $parametros['nroAsuntoFiscal'] = $request->query->get('nroAsuntoFiscal');
            $parametros['nroOficioFiscal'] = $request->query->get('nroOficioFiscal');
            $parametros['nombreImputado'] = $request->query->get('nombreImputado');
            $parametros['nombreVictima'] = $request->query->get('nombreVictima');
            $parametros['acusacionPrivada'] = $request->query->get('acusacionPrivada');
            $parametros['horaInicio'] = $request->query->get('horaInicio');
            $parametros['horaFin'] = $request->query->get('horaFin');
            
            // Creo la consulta de los datos del formulario
            $qb->join('c.distribucion','d');

            if($parametros['id']!='')
                $qb->andWhere ('d.id = :id')
                    ->setParameter('id', $parametros['id']);
            
            if($parametros['tribunal']!='')
                $qb->andWhere ('d.tribunal = :tribunal')
                    ->setParameter('tribunal', $parametros['tribunal']);

            if($parametros['tribunaltipo'] != ''){
                $qb->join('d.tribunal', 't');
                $qb->andWhere('t.tribunalTipo = :tribunaltipo')
                    ->setParameter('tribunaltipo',$parametros['tribunaltipo']);
            }
            
            if($parametros['causa'] != '')
                $qb->andWhere ('d.causa = :causa')
                    ->setParameter('causa', $parametros['causa']);
            
            if($parametros['nroAsuntoFiscal'] != '')
                $qb->andWhere ($qb->expr()->like('c.nroAsuntoFiscal', "'%".$parametros['nroAsuntoFiscal']."%'"));
            
            if($parametros['nroOficioFiscal'] != '')
                $qb->andWhere ($qb->expr()->like('c.nroOficioFiscal', "'%".$parametros['nroOficioFiscal']."%'"));
            
            if($parametros['nombreImputado'] != '')
                $qb->andWhere ($qb->expr()->like('c.nombreImputado', "'%".$parametros['nombreImputado']."%'"));
            
            if($parametros['nombreVictima'] != '')
                $qb->andWhere ($qb->expr()->like('c.nombreVictima', "'%".$parametros['nombreVictima']."%'"));
            
            if($parametros['acusacionPrivada'] != '')
                $qb->andWhere ('c.acusacionPrivada = :acusacionPrivada')
                ->setParameter('acusacionPrivada', $parametros['acusacionPrivada']);
            
            if($parametros['horaInicio'] != '')
                $qb->andWhere ('c.creado >= :horaInicio')
                ->setParameter('horaInicio', $parametros['horaInicio']);
            
            if($parametros['horaFin'] != '')
                $qb->andWhere ('c.creado <= :horaFin')
                ->setParameter('horaFin', $parametros['horaFin']);
        
        $qb->orderBy('c.creado','desc');    
            
        $casos = $qb->getQuery()->getResult();    
            
        // create new PDF document
        $pdf = new Resumen('L', 'mm', 'A4', true, 'UTF-8', false);
        
        $pdf->setLogo($this->getAssetUrl('bundles/inhack20controldistribucion/images/escudo.jpeg'));
        
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
        $PDF_MARGIN_TOP = 75;
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
        
        $html.='            
        <table style="text-align: center; width: 100%;" border="1" cellpadding="1" cellspacing="0">
            <tbody>
                <tr style="background-color: rgb(183, 184, 184);">
                    <td style="width: 3%">N&deg;</td>
                    <td style="width: 10%">Fecha</td>
                    <td style="width: 8%">Hora</td>
                    <td style="width: 13%">N&deg; Asunto</td>
                    <td style="width: 12%">N&deg; Oficio</td>
                    <td style="width: 14%">Imputado</td>
                    <td style="width: 14%">Victima</td>
                    <td style="width: 16%">Tribunal</td>
                    <td style="width: 10%">Recibe</td>
                </tr>
                ';
        $i = 1;$caso= new Caso();
        foreach ($casos as $caso) {
            $html .='
                <tr>
                    <td style="">'.$i.'</td>
                    <td style="">'.$caso->getCreado()->format('d-m-Y').'</td>
                    <td style="">'.$caso->getCreado()->format('h:m a').'</td>
                    <td style="">'.$caso->getNroAsuntoFiscal().'</td>
                    <td style="">'.$caso->getNroOficioFiscal().'</td>
                    <td style="">'.$caso->getNombreImputado().'</td>
                    <td style="">'.$caso->getNombreVictima().'</td>
                    <td style="">'.ucwords($caso->getDistribucion()->getTribunal()->getDescripcion()).'</td>
                    <td>&nbsp;</td>    
                </tr>
            ';
            $i++;
        }
                
        $html .='
            </tbody>
        </table>
        ';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf->Output();
    }
    
    private function getAssetUrl($path, $packageName = null)
    {
        return $this->container->get('templating.helper.assets')->getUrl($path, $packageName);
    }
}
