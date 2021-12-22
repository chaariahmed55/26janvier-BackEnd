<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;


class ArchiveController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/archive", name="archive")
     */
    public function index(): Response
    {
        return $this->render('archive/index.html.twig', [
            'controller_name' => 'ArchiveController',
        ]);
    }

    /**
     * @Route("/archive/getall" , methods={"GET"} , name="gettallarchive")
     */
    public function getallarchive(){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $archive = $this->getDoctrine()->getManager()->getRepository(Archive::class)->findAll();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($archive, null, ['groups' =>
            'archive']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/archive/add", name="addarchive", methods={"POST"})
     */
    public function add(Request $request)
    {
        $archive = new Archive();
        $data=$request->get('data');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $archive->setData($data);
        $archive->setAdmin($admin);
        $this->entityManager->persist($archive);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/archive/update/{id}", name="update-archive", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $archive = $this->getDoctrine()->getManager()->getRepository(Archive::class)->findOneBy(['id'=>$id]);
        $data=$request->get('data');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $archive->setData($data);
        $archive->setAdmin($admin);
        $this->entityManager->persist($archive);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/archive/delete/{id}", name="delete_archive", methods={"POST"})
     */
    public function delete($id){
        $archive = $this->getDoctrine()->getManager()->getRepository(Archive::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($archive);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }

}
