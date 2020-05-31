<?php
namespace App\Controller;

use App\Entity\AtividadeTipo;
use App\Repository\AtividadeTipoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class Atividade extends ApiController
{
    /**
    * @Route("/atividades", methods="GET")
    */
    public function index(AtividadeTipoRepository $atividadeTipoRepository)
    {
        if (! $this->isAuthorized()) {
            return $this->respondUnauthorized();
        }

        $atividades = $atividadeTipoRepository->transformAll();

        return $this->respond($atividades);
    }

    /**
    * @Route("/atividades", methods="POST")
    */
    public function create(Request $request, AtividadeTipoRepository $atividadeTipoRepository, EntityManagerInterface $em)
    {
        if (! $this->isAuthorized()) {
            return $this->respondUnauthorized();
        }
        
        $request = $this->transformJsonBody($request);
        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get('title')) {
            return $this->respondValidationError('Please provide a title!');
        }

        // persist the new atividade
        $atividade = new AtividadeTipo;
        $atividade->setTitle($request->get('title'));
        $em->persist($atividade);
        $em->flush();

        return $this->respondCreated($atividadeTipoRepository->transform($atividade));
    }

}