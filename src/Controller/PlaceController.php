<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlaceRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface; 

class PlaceController extends AbstractController
{
    #[Route("/api/place", name: "api_place", methods: ["GET"])]
    public function index(PlaceRepository $placeRepository, NormalizerInterface $normalizer): Response 
    { 
        $place = $placeRepository->findAll();         
        $normalized = $normalizer->normalize($place,null,['groups'=>'place:read']);  
        $json = json_encode($normalized);         
        $response = new Response($json, 200, [ 
            'Content-Type' => 'application/json'             
        ]);             
        return $response; 
    } 

    #[Route("/api/place/{id}", name: "api_place_avec_id", methods: ["GET"])]
    public function findById(PlaceRepository $placeRepository, int $id, NormalizerInterface $normalizer): Response 
    {        
        $place = $placeRepository->find($id); 
        // vérif si place existe:
        // if (!$place) {
        //     return new Response(json_encode(['error' => 'Place not found']), 404, [
        //         'Content-Type' => 'application/json',
        //     ]);
        // }
        $normalized = $normalizer->normalize($place,null,['groups'=>'place:read']); 
        $json = json_encode($normalized);         
        $response = new Response($json, 200, [ 
            'Content-Type' => 'application/json'             
        ]);             
        return $response; 
    } 
}
