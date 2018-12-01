<?php
/**
 * Created by PhpStorm.
 * User: lapiscine
 * Date: 24/11/2018
 * Time: 19:27
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Commentaires;
use AppBundle\Entity\Courses;
use AppBundle\Entity\Villes;
use AppBundle\Form\CommentairesType;
use AppBundle\Form\CoursesType;
use AppBundle\Repository\CoursesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{

    /**
     * @Route("/courses", name="courses")
     */

    public function toutesLesCourses(){

        $repository = $this->getDoctrine()->getRepository(Courses::class);
        $repositoryVille = $this->getDoctrine()->getRepository(Villes::class);


        $course = $repository->findAll();
        $ville = $repositoryVille->findAll();

        return $this->render('@App/courses/courses.html.twig',[
            'courses' => $course,
            'villes' => $ville,

        ]);
    }


    /**
     * @Route("/courses/show/{id}", name="show_course")
     * @param $id
     * @param Request $request
     * @return Response
     */

    public function showCourses($id, Request $request){

        $repository = $this->getDoctrine()->getRepository(Courses::class);
        $repositoryCommentaires = $this->getDoctrine()->getRepository(Commentaires::class);

        $courses = $repository->find($id);

        $form = $this->createForm(CommentairesType::class, new Commentaires());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $commentaire = $form->getData();
                $em = $this->getDoctrine()->getManager();

                $user = $this->get('security.token_storage')->getToken()->getUser();
                $commentaire->setUser($user);
                $commentaire->setCourse($courses);

                $em->persist($commentaire);
                $em->flush();

                $this->addFlash(
                    'commentaire',
                    'Votre commentaire à bien été enregistrée, merci! '
                );

                return $this->redirectToRoute('show_course', ['id' => $id]);

            } else {
                $this->addFlash(
                    'commentaire',
                    'Une erreur est survenue lors de l\'enregistrement de votre commentaire '
                );
            }
        }

        $commentairesCourse = $repositoryCommentaires->findBy(['course' => $courses]);


        return $this->render('@App/courses/show.html.twig',[
            'course' => $courses,
            'formCommentaires' => $form->createView(),
            'commentairesCourses' => $commentairesCourse
        ]);
    }


    /**
     * @Route("/ByGenre/{idVille}", name="ville")
     * @param $idVille
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function courseByVille($idVille)
    {
        /** @var $repository CoursesRepository* */
        $repository = $this->getDoctrine()->getRepository(Courses::class);

        $repositoryVille = $this->getDoctrine()->getRepository(Villes::class);

        $ville = $repositoryVille->find($idVille);

        $courses = $repository->getCourseByVille($ville);


        return $this->render('@App/courses/courses_ville.html.twig', [
            'courses' => $courses,
            'ville' => $ville,
        ]);

    }

    /**
     *
     * @Route("/ajoutcourse", name="ajout_course")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    public function ajoutCourse(Request $request)
    {


        $form = $this->createForm(CoursesType::class, new Courses());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $course = $form->getData();
                $em = $this->getDoctrine()->getManager();

                $user = $this->get('security.token_storage')->getToken()->getUser();

                $course->setUser($user);

                $em->persist($course);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Votre course à bien été enregistrée, merci! '
                );

                return $this->redirectToRoute('courses');

            } else {
                $this->addFlash(
                    'notice',
                    'Une erreur est survenue lors de l\'enregistrement de votre course '
                );
            }
        }

        return $this->render(
            '@App/courses/ajout_course.html.twig',
            [
                'formCourses' => $form->createView()
            ]
        );
    }



    /**
     *
     * @Route("/modifcourse/{id}", name="modif_course")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    public function modifCourse(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Courses');
        $course = $repository->find($id);

        $form = $this->createForm(CoursesType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){



            $course = $form->getData();

            $em->persist($course);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre course à bien été modifiée, merci! '
            );

            return $this->redirectToRoute('courses');

        }else
            $this->addFlash(
                'notice',
                'Une erreur est survenue lors de la modification de votre course ');
            return $this->render('@App/courses/modif_course.html.twig',
                [
                    'formCourses' => $form->createView()
                ]
            );
    }




}