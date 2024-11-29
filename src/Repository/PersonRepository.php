<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findAllWithPlaces(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.placesLiked', 'pl') // Relation avec placesLiked
            ->addSelect('pl') // Charge les données associées
            ->getQuery()
            ->getResult();
    }
}
