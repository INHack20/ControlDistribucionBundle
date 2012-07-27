<?php

namespace INHack20\ControlDistribucionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use INHack20\ControlDistribucionBundle\Entity\TribunalTipo;
use INHack20\ControlDistribucionBundle\Entity\Tribunal;
use INHack20\ControlDistribucionBundle\Entity\Grupo;
use INHack20\ControlDistribucionBundle\Entity\Horario;
use INHack20\ControlDistribucionBundle\Entity\Causa;
use INHack20\ControlDistribucionBundle\Entity\Distribucion;
use INHack20\ControlDistribucionBundle\Entity\Estado;
use INHack20\ControlDistribucionBundle\Entity\Fiscalia;
use INHack20\ControlDistribucionBundle\Entity\Caso;

/**
 * Description of ControlDistribucionFixtures
 *
 * @author inhack20
 */
class ControlDistribucionFixtures implements FixtureInterface {
    
    public function load(ObjectManager $manager) {
        
        $estado = new Estado();
        $estado->setNombre('Anzoátegui');
        $manager->persist($estado);
        
        $estadoApure = new Estado();
        $estadoApure->setNombre('Apure');
        $manager->persist($estadoApure);
        
        $estado = new Estado();
        $estado->setNombre('Aragua');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Barinas');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Bolívar');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Carabobo');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Cojedes');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Delta Amacuro');
        $manager->persist($estado);
                   
        $estado = new Estado();
        $estado->setNombre('Distrito Capital');
        $manager->persist($estado);
                    
        $estado = new Estado();
        $estado->setNombre('Falcón');
        $manager->persist($estado);
                    
        $estado = new Estado();
        $estado->setNombre('Guárico');
        $manager->persist($estado);
                    
        $estado = new Estado();
        $estado->setNombre('Lara');
        $manager->persist($estado);
                    
        $estado = new Estado();
        $estado->setNombre('Mérida');
        $manager->persist($estado);
                    
        $estado = new Estado();
        $estado->setNombre('Miranda');
        $manager->persist($estado);
                    
        $estado = new Estado();
        $estado->setNombre('Monagas');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Nueva Esparta');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Portuguesa');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Sucre');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Táchira');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Trujillo');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Vargas');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Yaracuy');
        $manager->persist($estado);
        
        $estado = new Estado();
        $estado->setNombre('Zulia');
        $manager->persist($estado);
        
        $fiscalias = '1-16';
        $fiscalia = null;
        if(in_array('-',str_split($fiscalias)))
        {
            $fiscalias = explode('-', $fiscalias);
            if(count($fiscalias)==2)
            {
                $fiscalias = range($fiscalias[0], $fiscalias[1]);
                foreach ($fiscalias as $valor) {
                    $fiscalia = new Fiscalia();
                    $fiscalia->setNombre('FISCALIA '. strtoupper($this->numeroToOrdinal($valor)));
                    $fiscalia->setEstado($estadoApure);
                        $manager->persist($fiscalia);
                    
                }
            }
        }
        
        
        
        $horario = new Horario();
        $horario->setDias('LUN-MAR,VIE');
        $horario->setHoraInicio(new \DateTime('1970-01-01 08:30:00'));
        $horario->setHoraFin(new \DateTime('1970-01-01 15:30:00'));
            $manager->persist($horario);
        
        $horario2 = new Horario();
        $horario2->setDias('SAB-DOM');
        $horario2->setHoraInicio(new \DateTime('1970-01-01 12:00:00'));
        $horario2->setHoraFin(new \DateTime('1970-01-01 15:30:00'));
            $manager->persist($horario2);
        
        $horario3 = new Horario();
        $horario3->setDias('SAB');
        $horario3->setHoraInicio(new \DateTime('1970-01-01 12:00:00'));
        $horario3->setHoraFin(new \DateTime('1970-01-01 15:30:00'));
            $manager->persist($horario3);
        
        $grupoA = new Grupo();
        $grupoA->setNombre('A');
        $grupoA->addHorario($horario);
        $grupoA->addHorario($horario3);
            $manager->persist($grupoA);
        
        $grupoB = new Grupo();
        $grupoB->setNombre('B');
        $grupoB->addHorario($horario);
            $manager->persist($grupoB);
        
        $tribunalTipoControl = new TribunalTipo();
        $tribunalTipoControl->setNombre('Control');
        $tribunalTipoControl->setLimiteCausas(3);
            $manager->persist($tribunalTipoControl);
            
        $tribunalTipoJuicio = new TribunalTipo();
        $tribunalTipoJuicio->setNombre('Juicio');
        $tribunalTipoJuicio->setLimiteCausas(2);
            $manager->persist($tribunalTipoJuicio);
            
        $tribunalControl1 = new Tribunal();
        $tribunalControl1->setNro(1);
        $tribunalControl1->setTribunalTipo($tribunalTipoControl);
        $tribunalControl1->setHabilitado(true);
        $tribunalControl1->setDespacho(true);
            $manager->persist($tribunalControl1);
        
        $tribunalControl2 = new Tribunal();
        $tribunalControl2->setNro(2);
        $tribunalControl2->setTribunalTipo($tribunalTipoControl);
        $tribunalControl2->setHabilitado(true);
        $tribunalControl2->setDespacho(true);
            $manager->persist($tribunalControl2);
        
        $tribunalControl3 = new Tribunal();
        $tribunalControl3->setNro(3);
        $tribunalControl3->setTribunalTipo($tribunalTipoControl);
        $tribunalControl3->setHabilitado(true);
        $tribunalControl3->setDespacho(true);
            $manager->persist($tribunalControl3);
        
        $tribunalJuicio1 = new Tribunal();
        $tribunalJuicio1->setNro(1);
        $tribunalJuicio1->setTribunalTipo($tribunalTipoJuicio);
        $tribunalJuicio1->setHabilitado(true);
        $tribunalJuicio1->setDespacho(true);
            $manager->persist($tribunalJuicio1);
        
        $tribunalJuicio2 = new Tribunal();
        $tribunalJuicio2->setNro(2);
        $tribunalJuicio2->setTribunalTipo($tribunalTipoJuicio);
        $tribunalJuicio2->setHabilitado(true);
        $tribunalJuicio2->setDespacho(true);
            $manager->persist($tribunalJuicio2);
        
        $causaControl1 = new Causa();
        $causaControl1->setNombre('Procedimiento');
        $causaControl1->setTribunalTipo($tribunalTipoControl);
        $causaControl1->setGrupo($grupoA);
            $manager->persist($causaControl1);
        
        $causaControl2 = new Causa();
        $causaControl2->setNombre('Sobreseimiento');
        $causaControl2->setTribunalTipo($tribunalTipoControl);
        $causaControl2->setGrupo($grupoB);
            $manager->persist($causaControl2);
        
        $causaControl3 = new Causa();
        $causaControl3->setNombre('Desestimación');
        $causaControl3->setTribunalTipo($tribunalTipoControl);
        $causaControl3->setGrupo($grupoB);
            $manager->persist($causaControl3);
        
        $causaControl4 = new Causa();
        $causaControl4->setNombre('Querella');
        $causaControl4->setTribunalTipo($tribunalTipoControl);
        $causaControl4->setGrupo($grupoB);
            $manager->persist($causaControl4);
        
        $causaJuicio1 = new Causa();
        $causaJuicio1->setNombre('Apertura a Juicio');
        $causaJuicio1->setTribunalTipo($tribunalTipoJuicio);
        $causaJuicio1->setGrupo($grupoA);
            $manager->persist($causaJuicio1);
        
        $causaJuicio2 = new Causa();
        $causaJuicio2->setNombre('Querella');
        $causaJuicio2->setTribunalTipo($tribunalTipoJuicio);
        $causaJuicio2->setGrupo($grupoB);
            $manager->persist($causaJuicio2);
        
        $causaJuicio3 = new Causa();
        $causaJuicio3->setNombre('Acusación Privada');
        $causaJuicio3->setTribunalTipo($tribunalTipoJuicio);
        $causaJuicio3->setGrupo($grupoB);
            $manager->persist($causaJuicio3);
        
        /** Fixtures de casos distribuidos **/
        $nroAsuntoFiscal = "04-V4-0146-";
        $nombresVictimas = array(
            'Carlos Mendoza', 'Anais Ortega', 'Maria Barrios',' Yorman Montilla','Yhoana Sanchez',
            'Yorvic Montilla' , 'Ariana Ortega', 'Ana Mora', 'Linda Lopez',
        );
        $nombresImputados = array(
            'Eric Leon', 'Angelo Marquez', 'Pedro Peraza', 'Pedro Borquez','Juan Olivo','Rosaio Jaime',
            'Ana Pachecho' , 'Ariana Andreina', 'Ariana Perez'
        );
        print count($nombresImputados);
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl3);
        $distribucion->setCausa($causaControl1);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."01");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl1);
        $distribucion->setCausa($causaControl2);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."02");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl3);
        $distribucion->setCausa($causaControl1);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."03");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);

        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl1);
        $distribucion->setCausa($causaControl3);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."04");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl2);
        $distribucion->setCausa($causaControl3);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."05");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl2);
        $distribucion->setCausa($causaControl4);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."06");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio1);
        $distribucion->setCausa($causaJuicio2);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."09");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio2);
        $distribucion->setCausa($causaJuicio2);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."09");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio2);
        $distribucion->setCausa($causaJuicio1);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."09");
            $caso->setPieza("3");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio1);
        $distribucion->setCausa($causaJuicio3);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."09");
            $caso->setPieza("1");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio1);
        $distribucion->setCausa($causaJuicio2);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."09");
            $caso->setPieza("2");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio2);
        $distribucion->setCausa($causaJuicio3);
        
            $caso = new Caso();
            $caso->setFiscalia($fiscalia);
            $caso->setDistribucion($distribucion);
            $caso->setNroAsuntoFiscal($nroAsuntoFiscal."09");
            $caso->setPieza("2");
            $caso->setNombreImputado($nombresImputados[rand(0,8)]);
            $caso->setNombreVictima($nombresVictimas[rand(0,8)]);
            $caso->setNroOficioFiscal("desconocido");
                $manager->persist($caso);
        
        /*
                
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl1);
        $distribucion->setCausa($causaControl1);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl1);
        $distribucion->setCausa($causaControl2);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl2);
        $distribucion->setCausa($causaControl1);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl2);
        $distribucion->setCausa($causaControl3);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalControl3);
        $distribucion->setCausa($causaControl1);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio1);
        $distribucion->setCausa($causaJuicio1);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio1);
        $distribucion->setCausa($causaJuicio2);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio2);
        $distribucion->setCausa($causaJuicio1);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio2);
        $distribucion->setCausa($causaJuicio2);
            $manager->persist($distribucion);
        
        $distribucion = new Distribucion();
        $distribucion->setTribunal($tribunalJuicio2);
        $distribucion->setCausa($causaJuicio3);
            $manager->persist($distribucion);
        */
        
        $usuario = $manager->getRepository('INHack20UserBundle:User')->findOneBy(array(
            'username' => 'ADMIN',
        ));    
        $usuario->setEstado($estadoApure);    
            $manager->persist($usuario);
        
        $manager->flush();
    }
    
    private function numeroToOrdinal($nro){
        
                    $nrosOrdinalesFemeninos = array(
                    0 => '',
                    1 => 'primera',
                    2 => 'segunda',
                    3 => 'tercera',
                    4 => 'cuarta',
                    5 => 'quinta',
                    6 => 'sexta',
                    7 => 'septima',
                    8 => 'octava',
                    9 => 'novena',
                    10 => 'decima',
                    20 => 'vigesima',
                    30 => 'trigesima',
                    40 => 'cuadragesima',
                    50 => 'quincuagesima',
                    60 => 'sexagesima',
                );
                if($nro >= 0 && $nro<=10)
                    {
                        $nro = $nrosOrdinalesFemeninos[$nro];
                    }
                elseif($nro >= 11 && $nro<=19){
                        $nro = $nrosOrdinalesFemeninos[10] . ' ' . $nrosOrdinalesFemeninos[$nro - 10];
                }    
                elseif($nro >= 20 && $nro<=99){
                        $resto = (floor($nro / 10)) * 10;
                        $nro = $nrosOrdinalesFemeninos[$resto] . ' ' . $nrosOrdinalesFemeninos[$nro - $resto];
                }
                return $nro;
     }//fin funcion
}