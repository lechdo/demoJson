<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personne;
use AppBundle\Form\PersonneType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

       $form = $this->createForm(PersonneType::class);
       $form->add("valider", ButtonType::class);
        return $this->render('default/index.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/api-get", name="apiGet")
     * @param Request $request
     * @param EntityManager $em
     * @param SerializerInterface $serializer
     * @return
     */
    public function getListPersonneApi(Request $request, EntityManagerInterface $em, SerializerInterface $serializer) {
        $repoPersonnes = $em->getRepository(Personne::class);
        $personnes = $repoPersonnes->findAll();

        $retour = $serializer->normalize($personnes);

        return new JsonResponse($retour);
    }

    /**
     * @Route("/api-post", name="apiPost")
     * @param Request $request
     * @param EntityManager $em
     * @return null
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersonneApi(Request $request, EntityManagerInterface $em) {
        dump($request);

        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        $age = $request->get("age");

        $personne = new Personne();
        $personne->setNom($nom);
        $personne->setPrenom($prenom);
        $personne->setAge($age);


        $em->persist($personne);
        $em->flush();




        return new Response("la requete a été effectuée");
    }
}
