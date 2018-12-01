<?php
/**
 * Created by PhpStorm.
 * User: maximemerle
 * Date: 26/11/2018
 * Time: 21:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Courses;
use AppBundle\Entity\Villes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * @Route("/admin/admin", name="admin")
     *
     */

    public function AdminPage(){

        $repository = $this->getDoctrine()->getRepository(Courses::class);
        $repositoryVille = $this->getDoctrine()->getRepository(Villes::class);


        $course = $repository->findAll();
        $ville = $repositoryVille->findAll();

        return $this->render('@App/admin/admin.html.twig',[
            'courses' => $course,
            'villes' => $ville
        ]);
    }



    /**
     *
     * @Route("/supprimerCourse/{id}", name="supprimer_course")
     * @param $id
     * @return Response
     */

    public function SupprLivreAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Courses::class);
        $entityManager = $this->getDoctrine()->getManager();

        $course = $repository->find($id);

        $entityManager->remove($course);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Course bien supprimée ! '
        );

        return $this->redirectToRoute('courses');

    }
}