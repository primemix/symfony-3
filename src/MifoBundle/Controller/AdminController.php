<?php

namespace MifoBundle\Controller;

use MifoBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function adminAction()
    {
        return $this->render('@Mifo/admin/index.html.twig');
    }

    /**
     * Lists all movie entities.
     *
     */
    public function movieAction()
    {
        $em = $this->getDoctrine()->getManager();

        $movies = $em->getRepository('MifoBundle:Movie')->findAll();

        return $this->render('@Mifo/admin/movie/index.html.twig', array(
            'movies' => $movies,
        ));
    }

    /**
     * Creates a new movie entity.
     *
     */
    public function newAction(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm('MifoBundle\Form\MovieType', $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movie_show', array('id' => $movie->getId()));
        }

        return $this->render('@Mifo/admin/movie/new.html.twig', array(
            'movie' => $movie,
            'form' => $form->createView(),
        ));
    }
}
