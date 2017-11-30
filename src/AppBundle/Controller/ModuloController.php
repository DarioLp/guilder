<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Comision;
use AppBundle\Entity\Horario;
use AppBundle\Entity\Encuesta;
use AppBundle\Entity\Materiaelegida;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HTTPFoundation\Session\Session;

class ModuloController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    /**
     * @Route("/modulo1", name="modulo1")
     */
    public function modulo1Action(Request $request) {
        // Falta chequear el año y cuatrimestre
        $em = $this->getDoctrine()->getManager();

        $comision = new Comision();
        $form = $this->createForm('AppBundle\Form\ComisionType_1', $comision);
        $form->handleRequest($request);

        $materias = $em->getRepository('AppBundle:Materia')->findAll();

        return $this->render('modulo/modulo1.html.twig', array(
                    'materias' => $materias,
        ));
    }

    /**
     * @Route("/modulo2", name="modulo2")
     *  @Method({"GET", "POST"})
     */
    public function modulo2Action(Request $request) {
        $comision = new Comision();
        $form = $this->createForm('AppBundle\Form\ComisionType_1', $comision);
        $form->handleRequest($request);
        $comis = array();
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted()) {
            if ($comision->getCuatrimestre() == 1 or $comision->getCuatrimestre() == 2 or $comision->getCuatrimestre() == NULL) {
                if (($comision->getYear() >= 2011 and $comision->getYear() <= 2017) or $comision->getYear() == NULL) {
                    if ($comision->getYear() == null) {//Caso 1,la comision no tiene año
                        if ($comision->getCuatrimestre() == null) {//no tiene año y no tiene cuatrimestre
                            $comisions = $em->getRepository('AppBundle:Comision')->
                                    findBymateriamateria($comision->getMateriamateria());
                        } else {//no tiene año pero tiene cuatrimestre
                            $comisions = $em->getRepository('AppBundle:Comision')->findBy(array(
                                'materiamateria' => $comision->getMateriamateria(),
                                'cuatrimestre' => $comision->getCuatrimestre()
                            ));
                        }
                    } else {            //caso 2,la tiene año
                        if ($comision->getCuatrimestre() == null) {//la comision tiene año pero no tiene acuatrimestre
                            $comisions = $em->getRepository('AppBundle:Comision')->findBy(array(
                                'materiamateria' => $comision->getMateriamateria(),
                                'year' => $comision->getYear(),
                            ));
                        } else {//la comision tiene año y cuatrimestre
                            $comisions = $em->getRepository('AppBundle:Comision')->findBy(array(
                                'materiamateria' => $comision->getMateriamateria(),
                                'year' => $comision->getYear(),
                                'cuatrimestre' => $comision->getCuatrimestre()
                            ));
                        }
                    }
                    if (sizeof($comisions) == 0) {
                        $estado = 'No hay infoormacion sobre la materia solicitada en este periodo de tiempo';
                        $this->session->getFlashBag()->add("error", $estado);
                    }
                    $horarios = array();

                    foreach ($comisions as $comision) {
                        $horario = $em->getRepository('AppBundle:Horario')->findOneBycomisioncomision(
                                $comision->getIdcomision()
                        );
                        $horarios[] = $horario;
                    }

                    //creo un arreglo d forma de obtener todos los datos de la comision en un solo array
                    for ($i = 0; $i < sizeof($comisions); $i++) {
                        $array = [
                            'numero' => $comisions[$i]->getNumero(),
                            'profesor' => $comisions[$i]->getProfesor(),
                            'year' => $comisions[$i]->getYear(),
                            'cuatrimestre' => $comisions[$i]->getCuatrimestre(),
                            'materia' => $comisions[$i]->getMateriamateria()->__toString(),
                            'dia' => $horarios[$i]->getDiadia()->__toString(),
                            'inicio' => date_format($horarios[$i]->getInicio(), 'H:i'),
                            'fin' => date_format($horarios[$i]->getFin(), 'H:i'),
                            'segundos' => $horarios[$i]->restarHoras(),
                        ];
                        $comis[] = $array;
                    }

                    return $this->render('modulo/modulo2.html.twig', array(
                                'comis' => $comis,
                                'form' => $form->createView(),
                    ));
                } else {
                    $estado = 'El año ingresado es invalido';
                    $this->session->getFlashBag()->add("error", $estado);
                    return $this->redirectToRoute('modulo2');
                }
            } else {
                $estado = 'El numero de cuatrimestre es invalido';
                $this->session->getFlashBag()->add("error", $estado);
                return $this->redirectToRoute('modulo2');
            }
        } else {
            return $this->render('modulo/modulo2.html.twig', array(
                        'comis' => $comis,
                        'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/modulo3", name="modulo3")
     */
    public function modulo3Action(Request $request) {
        $man = $this->getDoctrine()->getManager();

        $materias = $man->getRepository('AppBundle:Materia')->findAll();

        return $this->render('modulo/modulo3.html.twig', array(
                    'materias' => $materias,
        ));
    }

    /**
     * @Route("/modulo3B", name="modulo3B")
     */
    public function modulo3BAction(Request $request) {

        return $this->render('modulo/modulo3B.html.twig');
    }

    /**
     * @Route("/encuesta1", name="encuesta1")
     */
    public function encuesta1Action(Request $request) {
        
        //Reviso que el botón submit haya sido apretado para que no me de valores nulos
        if (isset($_POST['submit'])) {
            if (isset($_POST['materia'])) {
                $listaMaterias = $_POST['materia'];
                $materiasSeleccionadas = array();
                $em = $this->getDoctrine()->getEntityManager();
                for($X = 0; $X < count($listaMaterias); $X++)
                {
                    $mat = $em->getRepository('AppBundle:Materia')->findOneBycodigo($listaMaterias[$X]);
                    $nombreMateria = $mat->getNombre(); 
                    array_push($materiasSeleccionadas, $nombreMateria);
                }
                return $this->render('modulo/modulo3B.html.twig', array(
                    'codigosMaterias' => $_POST['materia'], 'nombresMaterias' => $materiasSeleccionadas
                ));
            }
            else
            {
                $estado = 'Porfavor seleccione alguna opción.';
                $this->session->getFlashBag()->add("error",$estado);
                return $this->redirectToRoute('modulo3');  
            }
        }
        else
        {
            $estado = 'Sucedió un error inesperado, porfavor complete nuevamente la encuesta.';
            $this->session->getFlashBag()->add("error",$estado);
            return $this->redirectToRoute('modulo3');  
        }      
    }
    
    /**
     * @Route("/encuesta2", name="encuesta2")
     */
    public function encuesta2Action(Request $request) {
        if (isset($_POST['submit'])) {
            if (isset($_POST['turno'])){
                $datosRecibidos = $_POST['turno'];
                $turnosElegidos = array();
                $materiasElegidas = array();
                //Recibo los datos como "IC002,1", entonces lo corto por la coma y separo codigo y turno.
                for($X = 0; $X < count($datosRecibidos); $X++)
                {
                    $auxiliar = preg_split('~,~', $datosRecibidos[$X]);
                    array_push($materiasElegidas, $auxiliar[0]);
                    array_push($turnosElegidos, $auxiliar[1]);
                }
                
                $mane = $this->getDoctrine()->getEntityManager();      
                
                $materias = array();
                foreach($materiasElegidas as $X)
                {
                    //Busco las materias por su codigo para pasarselas a la Encuesta
                    $mat = $mane->getRepository('AppBundle:Materia')->findOneByCodigo($X);
                    array_push($materias, $mat);
                }
                
                //Defino hora local como la de Buenos Aires.
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                //Obtengo esa hora local y la guardo en una variable
                $fechaActual = date_default_timezone_get();
                
                $encuestas = array();
                for($A = 0; $A < count($materias); $A++)
                {
                    $encuesta = new Encuesta();
                    $encuesta->setFecha(new \DateTime($fechaActual));
                    $encuesta->setIdmateriaelegida($materias[$A]);
                    $encuesta->setTurno($turnosElegidos[$A]);
                    array_push($encuestas, $encuesta);           
                }              
                
                
                foreach($encuestas as $una)
                {
                    //Hago commit y push de las Encuestas creadas
                    $mane->persist($una);
                    $push = $mane->flush();
                }  
                if($push != null)
                    {
                        $estado = 'Eror, falló la encuesta. Porfavor ingrese las opciones de nuevo.';
                        $this->session->getFlashBag()->add("error",$estado);
                        return $this->redirectToRoute('modulo3');
                    }
                if($push == null)
                {  
                    $estado = 'Se completó la encuesta correctamente.';
                    $this->session->getFlashBag()->add("good",$estado);
                    return $this->redirectToRoute('homepage'); 
                }
                
            }
            else
                {
                    $estado = 'Debe seleccionar algún turno, porfavor complete la encuesta nuevamente.';
                    $this->session->getFlashBag()->add("error",$estado);
                    return $this->redirectToRoute('modulo3');  
                }
        }
        else
        {
            $estado = 'Sucedió un error inesperado, porfavor complete la encuesta nuevamente.';
            $this->session->getFlashBag()->add("error",$estado);
            return $this->redirectToRoute('modulo3');  
        }       
    }

    /**
     * @Route("/agregar_comisiones", name="agregar_comisiones")
     * @Method({"GET"})
     */
    public function obtenerComisionesAction(Request $request) {

        $codigo = $request->query->get('codigo');
        $em = $this->getDoctrine()->getManager();
        /* Busco las comisiones que concuerden con el id de la materia */
        $materia = $em->getRepository('AppBundle:Materia')
                ->findOneBycodigo($codigo);
        $idMateria = $materia->getIdmateria();
        $comisiones = $em->getRepository('AppBundle:Comision')
                ->findBymateriamateria($idMateria);
        $comiArray = array();
        foreach ($comisiones as $c) {
            /* Para cada comision del array $comisiones recupero los datos relevantes para el usuario
              Estos datos se añaden a un array temporal y luego se añaden al array $comiArray */
            $comision = array();
            $comision[] = $c->getProfesor();
            $comision[] = $c->getNumero();
            $horario = $em->getRepository('AppBundle:Horario')
                    ->findOneByComisioncomision($c);
            $comision[] = $horario->getInicio()->format('H');
            $comision[] = $horario->getInicio()->format('i');
            $comision[] = $horario->getFin()->format('H');
            $comision[] = $horario->getFin()->format('i');
            $comision[] = $horario->getDiadia()->getNombre();
            $comision[] = $materia->getNombre(); /* Buscar una mejor manera de pasar esta información */
            $comiArray[] = $comision;
        }
        /* Genero un json con las comisiones. El JSON no esta validado. ¿Por qué? */
        $jsondata = json_encode($comiArray);
        $response = new Response(
                'Content', Response::HTTP_OK, array('conten-Type', 'text/html')
        );
        $response->setContent($jsondata);
        return $response;
    }

}
