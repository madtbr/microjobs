<?php

namespace App\Controller;

use App\Entity\Servico;
use App\Form\ServicoType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ServicosController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/servicos", name="servicos")
     */
    public function index()
    {
        return $this->render('servicos/index.html.twig', [
            'controller_name' => 'ServicosController',
        ]);
    }

    /**
     * @Route("/painel/servicos/cadastrar", name="cadastrar_job")
     * @Template("servicos/novo-micro-jobs.html.twig")
     */
    public function cadastrar(Request $request, UserInterface $user)
    {
    $servico = new Servico();
    $form = $this->createForm(ServicoType::class, $servico);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imagem = $servico->getImagem();
        $nome_arquivo = md5(uniqid() ). $imagem->guessExtension();
        $imagem->move(
            $this->getParameter('caminho_img_job'),
            $nome_arquivo
        );
        $servico->setImagem($nome_arquivo);
        $servico->setUsuario($user);
        $servico->setValor(30.00);
        $servico->setStatus('A');
        $this->em->persist($servico);
        $this->em->flush();
        $this->addFlash("success", "Cadastrado com sucesso!");
        return $this->redirectToRoute('painel');
}


return [
    'form'  =>  $form->createView()
];
    }

    /**
     * @Route("/painel/servico/excluir/{id}", name="excluir_servico")
     * @param Servico $servico
     */
    public function excluir(Servico $servico)
    {
        $servico->setStatus("E");
        $this->em->persist($servico);
        $this->em->flush();
        $this->addFlash("success", "Excluido com sucesso!");
        return $this->redirectToRoute('painel');
    }
}
