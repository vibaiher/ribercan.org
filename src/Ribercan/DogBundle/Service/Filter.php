<?php

namespace Ribercan\DogBundle\Service;

use Ribercan\Admin\DogBundle\Entity\Dog;

class Filter
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function filterBy(Array $filters)
    {
        if ($filters['size'] != '' && $filters['age'] != '' && $filters['sex'] != '')
        {
            return $this->filterDogsBySexAndAgeAndSize($filters['sex'], $filters['age'], $filters['size']);
        }

        if ($filters['size'] != '' && $filters['sex'] != '')
        {
            return $this->filterDogsBySexAndSize($filters['sex'], $filters['size']);
        }

        if ($filters['age'] != '' && $filters['sex'] != '')
        {
            return $this->filterDogsBySexAndAge($filters['sex'], $filters['age']);
        }

        if ($filters['size'] != '' && $filters['age'] != '')
        {
            return $this->filterDogsByAgeAndSize($filters['age'], $filters['size']);
        }

        if ($filters['size'] != '')
        {
            return $this->filterDogsBySize($filters['size']);
        }

        if ($filters['sex'] != '')
        {
            return $this->filterDogsBySex($filters['sex']);
        }

        return $this->filterDogsByAge($filters['age']);
    }

    private function filterDogsBySize($size)
    {
        return $this->repository->findBy(
            array(
                'size' => $size
            )
        );
    }

    private function filterDogsBySex($sex)
    {
        return $this->repository->findBy(
            array(
                'sex' => $sex
            )
        );
    }

    private function filterDogsByAge($age)
    {
        $where_clause = ($age == Dog::PUPPY ? 'd.birthday > :birthday' : 'd.birthday <= :birthday');
        $query = $this->repository->createQueryBuilder('d')
            ->where($where_clause)
            ->setParameter('birthday', $this->oneYearAgo())
            ->getQuery();

        return $query->getResult();
    }

    private function filterDogsByAgeAndSize($age, $size)
    {
        $age_clause = ($age == Dog::PUPPY ? 'd.birthday > :birthday' : 'd.birthday <= :birthday');
        $query = $this->repository->createQueryBuilder('d')
            ->where("$age_clause AND d.size = :size")
            ->setParameter('birthday', $this->oneYearAgo())
            ->setParameter('size', $size)
            ->getQuery();

        return $query->getResult();
    }

    private function filterDogsBySexAndAge($sex, $age)
    {
        $age_clause = ($age == Dog::PUPPY ? 'd.birthday > :birthday' : 'd.birthday <= :birthday');
        $query = $this->repository->createQueryBuilder('d')
            ->where("$age_clause AND d.sex = :sex")
            ->setParameter('birthday', $this->oneYearAgo())
            ->setParameter('sex', $sex)
            ->getQuery();

        return $query->getResult();
    }

    private function filterDogsBySexAndSize($sex, $size)
    {
        $query = $this->repository->createQueryBuilder('d')
            ->where("d.sex = :sex AND d.size = :size")
            ->setParameter('sex', $sex)
            ->setParameter('size', $size)
            ->getQuery();

        return $query->getResult();
    }

    private function filterDogsBySexAndAgeAndSize($sex, $age, $size)
    {
        $age_clause = ($age == Dog::PUPPY ? 'd.birthday > :birthday' : 'd.birthday <= :birthday');
        $query = $this->repository->createQueryBuilder('d')
            ->where("$age_clause AND d.size = :size AND d.sex = :sex")
            ->setParameter('birthday', $this->oneYearAgo())
            ->setParameter('size', $size)
            ->setParameter('sex', $sex)
            ->getQuery();

        return $query->getResult();
    }

    private function oneYearAgo()
    {
        $today = new \DateTime();
        return $today->add(\DateInterval::createFromDateString('1 year ago'));
    }
}
