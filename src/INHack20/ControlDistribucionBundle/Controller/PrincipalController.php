<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PrincipalController extends Controller
{
    /**
     * @Route("/",name="_bienvenido")
     * @Template()
     */
    public function indexAction()
    {
                
       // create new PDF document
        $pdf = new \INHack20\ControlDistribucionBundle\TCPDF\Caso\Comprobante('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->setLogo($this->getAssetUrl('bundles/inhack20controldistribucion/images/escudo.jpeg'));
        $pdf->setLogo('bundles/inhack20controldistribucion/images/escudo.jpeg');
        
        
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
        $pdf->SetFont('helvetica', '', 12);
        

        //set margins
        $PDF_MARGIN_LEFT = 15;
        $PDF_MARGIN_TOP = 99;
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
                    <b>$fecha</b>
                    siendo las <b>$hora,</b>
                    se recibió la solicitud de
                    <b>$causa,</b>
                    constante
                    <b>(1)</b>
                    pieza, Emanada de la Fiscalía
                    <b>Cuarta</b>
                    del Ministerio Público, relacionado con el asunto Fiscal N°
                    <b>04-V4-0146-06</b>
                    ,seguido al imputado:
                    <b>$IMPUTADO,</b>
                     por la presunta comisiona de un delito en perjuicio de la víctima
                    <b>$VICTIMA.</b></p>
        
            ';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf->Output();
    }
    
    /**
     * Genera el menu dinamicamente de acuerdo a los datos almacenados.
     * 
     * @Template()
     */
    public function menuAction()
    {
         $em = $this->getDoctrine()->getEntityManager();
        
        $tipoTribunales = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->findAll();
        
        return array('tipoTribunales' => $tipoTribunales);
    }
    
    public function getAssetUrl($path, $packageName = null)
    {
        return $this->container->get('templating.helper.assets')->getUrl($path, $packageName);
    }
}
