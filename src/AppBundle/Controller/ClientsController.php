<?php

namespace AppBundle\Controller;

use AppBundle\Form\ClientFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Client;

class ClientsController extends Controller
{

    /**TODO move to the DB
    */
    private $titles = ['mr', 'ms', 'mrs', 'dr', 'mx'];

    /**
     * @Route("/guests", name="clients_index")
    */
    public function indexAction()
    {
        $data = [];
        $client_repo = $this ->getDoctrine()
                            ->getRepository('AppBundle:Client')
                            ->findAll();

        $data['clients'] =  $client_repo;

        return $this->render('@App/Clients/index.html.twig', $data );
    }

    /**
     * @Route("/guests/edit/{id_client}", name="clients_edit_index")
     * @param Request $request
     * @param $id_client
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDetail( Request $request, $id_client )
    {
        $data = [];
        $data['mode'] = 'edit_client'; // to switch same form state
        $data['form'] = [];
        $client_repo = $this ->getDoctrine()
                            ->getRepository('AppBundle:Client');
        $data['titles'] = $this->titles;
        $choices = array();
        foreach ($data['titles'] as $titleLabel) {
            $choices[$titleLabel] = $titleLabel;
        }

        $clientFromDb = $client_repo->find($id_client);

        $form = $this->createForm(ClientFormType::class, $clientFromDb);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() )
        {

            $em = $this ->getDoctrine()
                        ->getManager();
            $em->persist($clientFromDb);
            $em->flush();

            $this->addFlash(
                'notice',
                'Гость отредактирован.'
            );

            return $this->redirectToRoute('clients_index');

        }

        return $this->render('@App/Clients/form.html.twig', array(
            'form' => $form->createView(), 'data' => $data
        ));

    }

    /**
     * @Route("/guests/new", name="guest_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addClient( Request $request )
    {
        $data = [];
        $data['mode'] = 'add_client'; // to switch same form state
        $data['titles'] = $this->titles;
        $data['form']['title'] = '';

        $client = new Client();

        $form = $this->createForm(ClientFormType::class, $client);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid() )
            {

                $em = $this->getDoctrine()->getManager();
                $em->persist($client); // prepare date for exec
                $em->flush(); // create and exec query

                $this->addFlash(
                    'notice',
                    'Гость добавлен!'
                );

                return $this->redirectToRoute('clients_index');

            }

        return $this->render('@App/Clients/form.html.twig', array(
            'form' => $form->createView(), 'data' => $data
        ));

    }

}
