<?php

namespace INHack20\ControlDistribucionBundle\TCPDF\Caso;

/**
 * Description of ResumenDiario
 *
 * @author inhack20
 */
class Resumen extends \TCPDF {
    private $logo;
    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        $fechaHoy = new \DateTime();
        $html ='
            <p style="margin-bottom: 0cm;" align="center">
                REPUBLICA BOLIVARIANA DE VENEZUELA<br/>
                <img style="width: 48px; height: 48px;" alt="" src="'.$this->logo.'"><br/>
                PODER JUDICIAL
            </p>
            <p style="margin-bottom: 0cm; line-height: 1" align="center">Unidad de Recepción y
                Distribución de Documentos del Circuito Judicial Penal del Edo.Apure<br/>
                Área de Alguacilazgo<br/>
                San Fernando de Apure, <b>'.$fechaHoy->format('d-m-Y').'</b><br/>
                <b>202° y 153°</b><br/><br/>
            </p>
            <br/>
        ';
        $this->writeHTML($html, true, false, true, false, '');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        
        // Page number
        $this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    
    public function setLogo($logo) {
        $this->logo = $logo;
    }
}

?>