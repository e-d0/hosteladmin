<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservationsController extends Controller
{
    /**
     * @Route("/reservations", name="reservations")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Reservation')->getBookedRooms();

        return $this->render('@App/Reservations/index.html.twig', [ 'data' => $data ]);
    }

    /**
     * @Route("/reservation/{id_client}", name="booking")
     **/
    public function book(Request $request, $id_client)
    {
        $data = [];
        $data['id_client'] = $id_client;


        $data['rooms'] = null;
        $data['dates']['from'] = '';
        $data['dates']['to'] = '';
        $form = $this   ->createFormBuilder()
            ->add('dateFrom')
            ->add('dateTo')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $form_data = $form->getData();

            $data['dates']['from'] = $form_data['dateFrom'];
            $data['dates']['to'] = $form_data['dateTo'];

            $em = $this->getDoctrine()->getManager();
            $rooms = $em->getRepository('AppBundle:Room')
                ->getAvailableRooms($form_data['dateFrom'], $form_data['dateTo']);

            $data['rooms'] = $rooms;

        }

        $client = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->find($id_client);

        $data['client'] = $client;

        return $this->render('@App/Reservations/book.html.twig', $data);
    }

    /**
     * @Route("/reservation/edit/{id_reservation}", name="edit_booking")
     **/
    public function bookEdit(Request $request, $id_reservation)
    {
        $data = [];
        $data['id_reservation'] = $id_reservation;

        $em = $this->getDoctrine()->getManager();
        $reserv = $em->getRepository('AppBundle:Reservation')
                     ->find($id_reservation);

        $data['room'] = $reserv->getRoom()->getName();

        $data['dates']['from'] = $reserv->getDateIn()->format('Y-m-d H:i:s');
        $data['dates']['to'] = $reserv->getDateOut()->format('Y-m-d H:i:s');

        $data['client'] = $reserv->getClient();

        $form = $this->createFormBuilder()
            ->add('room', TextType::class )
            ->add('dateFrom', TextType::class )
            ->add('dateTo' , TextType::class )
            ->getForm();

        $form->handleRequest($request, $reserv);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();

            $em->remove($reserv);
            $em->flush();

            $this->addFlash(
                'notice',
                'Бронь успешно удалена.'
            );

            return $this->redirectToRoute('reservations');

        }

        return $this->render('@App/Reservations/book_edit.html.twig', $data);
    }

    /**
     * @Route("/book_room/{id_client}/{id_room}/{date_in}/{date_out}", name="book_room")
     **/
    public function bookRoom($id_client, $id_room, $date_in, $date_out)
    {

        $reservation = new Reservation();
        $date_start = new \DateTime($date_in);
        $date_end = new \DateTime($date_out);

        $reservation->setDateIn($date_start);
        $reservation->setDateOut($date_end);

        $client = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:Client')
                    ->find($id_client);

        $room = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:Room')
                    ->find($id_room);

        $reservation->setClient($client);
        $reservation->setRoom($room);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        $this->addFlash(
            'notice',
            'Номер успешно забронирован.'
        );

        return $this->redirectToRoute('clients_index');

    }

}
