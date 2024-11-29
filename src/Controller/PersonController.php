<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PersonRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface; 

class PersonController extends AbstractController
{
    #[Route('/api/person', name: "api_person", methods: ["GET"])]
    public function index(PersonRepository $personRepository, NormalizerInterface $normalizer): Response
    {
        // Utiliser la méthode avec JOIN FETCH
        $people = $personRepository->findAllWithPlaces();

        // Normalisation des données
        $data = $normalizer->normalize($people, null, [
            'groups' => ['person:read'],
            'enable_max_depth' => true, // Active la gestion de profondeur
        ]);

        return new Response(json_encode($data), 200, ['Content-Type' => 'application/json']);
    }

        #[Route('/api/person/{id}', name:"api_person_avec_id", methods: ["GET"])]
        public function findById(PersonRepository $personRepository, NormalizerInterface $normalizer,$id): Response     
        {         
            $person = $personRepository->find($id);         
            $normalized = $normalizer->normalize($person,null,['groups'=>'person:read']);           
            $json = json_encode($normalized);         
            $reponse = new Response($json, 200, [             
                'content-type' => 'application/json'             
            ]);             
            return $reponse;     
        }  
}
