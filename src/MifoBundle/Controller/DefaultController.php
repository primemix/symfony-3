<?php

namespace MifoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('MifoBundle:Movie')->findAll();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $movies,
            $request->query->getInt('page', 1),
            3
        );
        
        return $this->render('@Mifo/Default/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
