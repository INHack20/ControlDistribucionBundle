<?php

namespace INHack20\ControlDistribucionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use INHack20\ControlDistribucionBundle\Entity\TribunalTipo;
use INHack20\ControlDistribucionBundle\Entity\Tribunal;
use INHack20\ControlDistribucionBundle\Entity\Grupo;
use INHack20\ControlDistribucionBundle\Entity\Horario;
use INHack20\ControlDistribucionBundle\Entity\Causa;

/**
 * Description of ControlDistribucionFixtures
 *
 * @author inhack20
 */
class ControlDistribucionFixtures implements FixtureInterface {
    
    public function load(ObjectManager $manager) {
        $tribunalTipoControl = new TribunalTipo();
        $tribunalTipoControl->setNombre('Control');
            $manager->persist($tribunalTipoControl);
            
        $tribunalTipoJucio = new TribunalTipo();
        $tribunalTipoJucio->setNombre('Jucio');
            $manager->persist($tribunalTipoJucio);
            
        $tribunal = new Tribunal();
        $tribunal->setNro(1);
        $tribunal->setTribunalTipo($tribunalTipoControl);
            $manager->persist($tribunal);
        
        $tribunal = new Tribunal();
        $tribunal->setNro(2);
        $tribunal->setTribunalTipo($tribunalTipoControl);
            $manager->persist($tribunal);
        
        $tribunal = new Tribunal();
        $tribunal->setNro(3);
        $tribunal->setTribunalTipo($tribunalTipoControl);
            $manager->persist($tribunal);
        
        $tribunal = new Tribunal();
        $tribunal->setNro(1);
        $tribunal->setTribunalTipo($tribunalTipoJucio);
            $manager->persist($tribunal);
        
        $tribunal = new Tribunal();
        $tribunal->setNro(2);
        $tribunal->setTribunalTipo($tribunalTipoJucio);
            $manager->persist($tribunal);
        
        $causa = new Causa();
        $causa->setNombre('Procedimiento');
        $causa->setTribunalTipo($tribunalTipoControl);
            $manager->persist($causa);
        
        $causa = new Causa();
        $causa->setNombre('Sobreseimiento');
        $causa->setTribunalTipo($tribunalTipoControl);
            $manager->persist($causa);
        
        $causa = new Causa();
        $causa->setNombre('Desestimación');
        $causa->setTribunalTipo($tribunalTipoControl);
            $manager->persist($causa);
        
        $causa = new Causa();
        $causa->setNombre('Querella');
        $causa->setTribunalTipo($tribunalTipoControl);
            $manager->persist($causa);
        
        $causa = new Causa();
        $causa->setNombre('Procedimiento');
        $causa->setTribunalTipo($tribunalTipoJucio);
            $manager->persist($causa);
        
        $causa = new Causa();
        $causa->setNombre('Querella');
        $causa->setTribunalTipo($tribunalTipoJucio);
            $manager->persist($causa);
        
        $causa = new Causa();
        $causa->setNombre('Acusación Privada');
        $causa->setTribunalTipo($tribunalTipoJucio);
            $manager->persist($causa);
        
        $horario = new Horario();
        $horario->setDias('LUN-JUE');
        $horario->setHoraInicio(new \DateTime('1970-01-01 08:30:00'));
        $horario->setHoraFin(new \DateTime('1970-01-01 15:30:00'));
            $manager->persist($horario);
        
        $horario2 = new Horario();
        $horario2->setDias('VIE');
        $horario2->setHoraInicio(new \DateTime('1970-01-01 12:00:00'));
        $horario2->setHoraFin(new \DateTime('1970-01-01 15:30:00'));
            $manager->persist($horario2);
        
        $grupo = new Grupo();
        $grupo->setNombre('A');
        $grupo->addHorario($horario);
        $grupo->addHorario($horario2);
            $manager->persist($grupo);
        
        $grupo = new Grupo();
        $grupo->setNombre('B');
        $grupo->addHorario($horario);
            $manager->persist($grupo);
        
        $manager->flush();
    }
}