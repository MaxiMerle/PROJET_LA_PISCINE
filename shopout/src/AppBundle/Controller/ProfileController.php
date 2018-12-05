<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Courses;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Form;




class ProfileController extends Controller
{

    private $eventDispatcher;
    private $formFactory;
    private $userManager;


    /**
     * Edit the user.
     *@Route("/edit/user", name="user")
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $this->eventDispatcher = $this->get('event_dispatcher');
        $this->formFactory = $this->get('fos_user.profile.form.factory');
        $this->userManager = $this->get('fos_user.user_manager');


        $repository = $this->getDoctrine()->getRepository(Courses::class)->findAll();
        $course = $repository;

        $user = $this->getUser();
        $oldName = $user->getImage();


        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if ($user->getImage() !== NULL ) {
                $user = $form->getData();
                $file = $user->getImage();

                $imageName = md5(uniqid()) . "." . $file->guessExtension();

                // tente de sauvegarder l'image dans le dossier précisé
                try {
                    $file->move(
                        $this->getParameter("imgUser_directory"), $imageName);                } // en cas d'erreur il affiche le message contenu dans la variable $e
                catch (FileException $e) {
                    echo $e->getMessage() . "message erreur contenu dans la variable e. On peut mettre autre chose que le echo par exmple un retour sur une autre page ou autre....";
                }

                // récupère le nom de l'image généré par le md5 pour le sauvegarder en BDD
                $user->setImage($imageName);
            }else{
                $user->setImage($oldName);
            }
            // fin ajout image

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_edit');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
            'course' => $course,
        ));
    }




    /**
     *
     * @Route("/supprimerCourseUser/{id}", name="supprimer_course_user")
     * @param $id
     * @return Response
     */

    public function supprCourseAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Courses::class);
        $entityManager = $this->getDoctrine()->getManager();


        $course = $repository->find($id);

        $entityManager->remove($course);
        $entityManager->flush();

        $this->addFlash(
            'notice_admin',
            'Course bien supprimée ! '
        );

        return $this->redirectToRoute('user');

    }
}
