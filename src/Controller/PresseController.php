<?php

namespace App\Controller;

use App\Entity\Presse;
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

class PresseController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/presse", name="presse")
     */
    public function index(): Response
    {
        return $this->render('presse/index.html.twig', [
            'controller_name' => 'PresseController',
        ]);
    }

    /**
     * @Route("/presse/getall" , methods={"GET"} , name="gettallpresse")
     */
    public function getallpresse(){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $presse = $this->getDoctrine()->getManager()->getRepository(Presse::class)->findAll();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($presse, null, ['groups' =>
            'presse']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/presse/add", name="add-presse", methods={"POST"})
     */
    public function add(Request $request)
    {
        $presse=new Presse();
        $name= $request->get('name');
        $type=$request->get('type');
        $presse->setName($name);
        $presse->setType($type);
        $this->entityManager->persist($presse);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/presse/update/{id}", name="update-presse", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $presse = $this->getDoctrine()->getManager()->getRepository(Presse::class)->findOneBy(['id'=>$id]);
        $name= $request->get('name');
        $type=$request->get('type');
        $presse->setName($name);
        $presse->setType($type);
        $this->entityManager->persist($presse);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/presse/delete/{id}", name="delete_presse", methods={"POST"})
     */
    public function delete($id){
        $presse = $this->getDoctrine()->getManager()->getRepository(Presse::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($presse);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }













}
