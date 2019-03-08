<?php

namespace App\Controller;

use App\Entity\Servico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class IndexController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="index")
     * @Template("index/index.html.twig")
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $busca = $request->get('busca');
        $micro_jobs =$this->em->getRepository(Servico::class)->findByListagem($busca);
        return [
            'micro_jobs' => $micro_jobs
        ];
    }

    /**
     * @Route("/painel", name="painel")
     * @Template("index/painel.html.twig")
     * @param UserInterface $user
     * @return array
     */
    public function painel(UserInterface $user, Request $request)
    {
        $status = $request->get('busca_filtro');
        $micro_jobs = $this->em->getRepository(Servico::class)
            ->findByUsuarioAndStatus($user, $status);
        return [
            'micro_jobs' => $micro_jobs,
            'status'    =>  $status
        ];
    }

    /**
     * @param Servico $servico
     * @Route("/micro-job/{slug}", name="visualizar_job")
     * @Template("index/visualizar-job.html.twig")
     */
    public function visualizar_job(Servico $servico){
        return[
            'job' => $servico
        ];
    }
}
