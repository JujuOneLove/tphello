<?php

namespace App\Controller;


use App\Entity\ActionUser;
use App\Entity\User;
use App\Event\ActionEvent;
use App\Event\AppEvent;
use App\Form\Type\ActionType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index", methods="GET")
     */
    public function index(Request $request, TranslatorInterface $translator, SessionInterface $session): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/serialize/{choice}", name="home_serialize", methods="GET", defaults={"choice"=null})
     */
    public function serialize(Request $request, SerializerInterface $serializer, $choice = null): Response
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        switch ($choice){
            case 1:
                $response->setContent($serializer->serialize($serializer->normalize($users, null, ['attributes' => ['username']]), 'json'));
                break;
            case 2:
                $response->setContent($serializer->serialize($serializer->normalize($users, null, ['attributes' => ['username']]), 'xml'));
                $response->headers->set('Content-Type', 'application/xml');
                break;
            case 3:
                $response->setContent($serializer->serialize($users, 'xml'));
                $response->headers->set('Content-Type', 'application/xml');
                break;
            case 4:
                $response->setContent($serializer->serialize($users, 'json', ['groups' => 'users']));
                break;
            case 5:
                $response->setContent($serializer->serialize($serializer->normalize($users, null, ['groups' => 'user']), 'json'));
                break;
            default:
                $response->setContent($serializer->serialize( $users, 'json'));
                break;
        }

        return $response;
    }


    /**
     * @Route("/serializeplus/{choice}", name="home_serialize_plus", methods="GET", defaults={"choice"=null})
     */
    public function serializePlus(Request $request, SerializerInterface $serializer, $choice = null): Response
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        switch ($choice){
            case 1:
                $response->setContent($serializer->serialize($serializer->normalize($users, null, ['attributes' => ['username']]), 'json'));
                break;
            case 2:
                $response->setContent($serializer->serialize($serializer->normalize($users, null, ['attributes' => ['username']]), 'xml'));
                $response->headers->set('Content-Type', 'application/xml');
                break;
            case 3:
                $response->setContent($serializer->serialize($users, 'xml'));
                $response->headers->set('Content-Type', 'application/xml');
                break;
            case 4:
                $response->setContent($serializer->serialize($users, 'json', ['groups' => 'users']));
                break;
            case 5:
                $response->setContent($serializer->serialize($serializer->normalize($users, null, ['groups' => 'user']), 'json'));
                break;
            default:
                $response->setContent($serializer->serialize( $users, 'json'));
                break;
        }
        return $response;
    }



    /**
     * @Route("/api", name="home_api", methods="GET")
     */
    public function api(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/api/show", name="home_api", methods="GET")
     */
    public function apiShow(Request $request, SerializerInterface $serializer): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($serializer->serialize( $this->getUser(), 'json'));
        return $response;
    }

}
