<?php

namespace INHack20\ControlDistribucionBundle\TCPDF\Caso;

/**
 * Description of Comprobante
 *
 * @author inhack20
 */
class Comprobante extends \TCPDF{
    
    private $logo;
    private $nroControlInterno;
    private $nombre;
    private $cargo;

    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
                                <b>202 ° y 153 °</b>
                            </p>
                            <br/>
                            <p style="margin-bottom: 0cm;" align="right">
                                N° Control Interno: '.$this->nroControlInterno.'
                            </p>
                       
        ';
        $this->writeHTML($html, true, false, true, false, '');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        
        $html = '
                <table style="text-align: left;  height: 48px;" border="0"
                    cellpadding="2" cellspacing="2">
                        <tbody>
                            <tr>
                                <td style="text-align: center;">
                                    '.$this->nombre.'<br>'.$this->cargo.'<br>
                                </td>
                                <td style="vertical-align: top; text-align: center;">
                                    RECIBIDO<br>
                                    SECRETARIO(A)<br>
                                </td>
                            </tr>
                        </tbody>
               </table>

            ';
        $this->SetY(-40);
        $this->writeHTML($html, true, false, true, false, '');
        // Page number
        $this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    
    public function setLogo($logo) {
        $this->logo = $logo;
    }
    public function setNroControlInterno($nroControlInterno) {
        $this->nroControlInterno = $nroControlInterno;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }
}