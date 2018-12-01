<?php

namespace AppBundle\Repository;


/**
 * CoursesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CoursesRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCourseByVille($ville)

    {

        // création de la requête
        $queryBuilder = $this->createQueryBuilder("course");

        // définition des paramètres de la requête
        $query = $queryBuilder
            ->select("course")
            ->where("course.ville = :ville")
            // setParameter sert à protéger contre les attaques SQL
            ->setParameter("ville", $ville)
            ->orderBy('course.createdAt', 'DESC')
            ->getQuery();

        // récupération des resultats dans un tableau
        $results = $query->getResult();

        return $results;

    }

    public function findAll()
    {
        return $this->findBy(array(), array('createdAt' => 'DESC'));
    }






}
