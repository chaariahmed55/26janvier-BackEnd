<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Entity\VideoP;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VideoPController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/video/p", name="video_p")
     */
    public function index(): Response
    {
        return $this->render('video_p/index.html.twig', [
            'controller_name' => 'VideoPController',
        ]);
    }


    /**
     * @Route("/videop/getall/{id}" , methods={"GET"} , name="getvideop")
     */
    public function getallvideop($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $videop = $this->getDoctrine()->getManager()->getRepository(VideoP::class)->findBy(['programme'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($videop, null, ['groups' =>
            'videop']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/videop/add", name="add-videop", methods={"POST"})
     */
    public function add(Request $request)
    {
        $videop = new VideoP();
        $date= $request->get('date');
        $path= $request->get('path');
        $description= $request->get('description');
        $idprogramme= $request->get('programme_id');
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$idprogramme]);
        if(!$programme){
            return $this->json('error',400);
        }
        $videop->setDate($date);
        $videop->setPath($path);
        $videop->setDescription($description);
        $videop->setProgramme($programme);
        $this->entityManager->persist($videop);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/videop/update/{id}", name="update-videop", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $videop = $this->getDoctrine()->getManager()->getRepository(VideoP::class)->findOneBy(['id'=>$id]);
        $date= $request->get('date');
        $path= $request->get('path');
        $description= $request->get('description');
        $idprogramme= $request->get('programme_id');
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$idprogramme]);
        if(!$programme){
            return $this->json('error',400);
        }
        $videop->setDate($date);
        $videop->setPath($path);
        $videop->setDescription($description);
        $videop->setProgramme($programme);
        $this->entityManager->persist($videop);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/videop/delete/{id}", name="delete_videop", methods={"POST"})
     */
    public function delete($id){
        $videop = $this->getDoctrine()->getManager()->getRepository(VideoP::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($videop);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }













}
