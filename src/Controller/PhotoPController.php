<?php

namespace App\Controller;

use App\Entity\PhotoP;
use App\Entity\Programme;
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

class PhotoPController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/p", name="photo_p")
     */
    public function index(): Response
    {
        return $this->render('photo_p/index.html.twig', [
            'controller_name' => 'PhotoPController',
        ]);
    }



    /**
     * @Route("/photop/getall/{id}" , methods={"GET"} , name="getphotop")
     */
    public function getallphotop($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photop = $this->getDoctrine()->getManager()->getRepository(PhotoP::class)->findBy(['programme'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photop, null, ['groups' =>
            'photop']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photop/add", name="add-photop", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photop = new PhotoP();
        $date= $request->get('date');
        $name= $request->get('name');
        $description= $request->get('description');
        $data= $request->get('data');
        $idprogramme= $request->get('programme_id');
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$idprogramme]);
        if(!$programme){
            return $this->json('error',400);
        }
        $photop->setDate($date);
        $photop->setName($name);
        $photop->setData($data);
        $photop->setDescription($description);
        $photop->setProgramme($programme);
        $this->entityManager->persist($photop);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photop/update/{id}", name="update-photop", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photop = $this->getDoctrine()->getManager()->getRepository(PhotoP::class)->findOneBy(['id'=>$id]);
        $date= $request->get('date');
        $name= $request->get('name');
        $description= $request->get('description');
        $data= $request->get('data');
        $idprogramme= $request->get('programme_id');
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$idprogramme]);
        if(!$programme){
            return $this->json('error',400);
        }
        $photop->setDate($date);
        $photop->setName($name);
        $photop->setData($data);
        $photop->setDescription($description);
        $photop->setProgramme($programme);
        $this->entityManager->persist($photop);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/photop/delete/{id}", name="delete_photop", methods={"POST"})
     */
    public function delete($id){
        $photop = $this->getDoctrine()->getManager()->getRepository(PhotoP::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photop);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }



}
