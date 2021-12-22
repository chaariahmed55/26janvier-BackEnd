<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\User;
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

class PartenaireController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/partenaire", name="partenaire")
     */
    public function index(): Response
    {
        return $this->render('partenaire/index.html.twig', [
            'controller_name' => 'PartenaireController',
        ]);
    }

    /**
     * @Route("/partenaire/getall" , methods={"GET"} , name="gettallpartenaire")
     */
    public function getallpartenaire(){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $partenaire = $this->getDoctrine()->getManager()->getRepository(Partenaire::class)->findAll();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($partenaire, null, ['groups' =>
            'partenaire']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/partenaire/getbytype/{type}" , methods={"GET"} , name="getpartenairebytype")
     */
    public function getpartenairebytype($type){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $partenaire = $this->getDoctrine()->getManager()->getRepository(Partenaire::class)->findBy(
            ['type' => $type]
        );
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($partenaire, null, ['groups' =>
            'partenaire']);
        return $this->json($data, 200);
    }



    /**
     * @Route("/partenaire/add", name="add-partenaire", methods={"POST"})
     */
    public function add(Request $request)
    {
        $partenaire=new Partenaire();
        $logo=$request->get('logo');
        $type=$request->get('type');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $partenaire->setLogo(str_replace(' ', '+', $logo));
        $partenaire->setType($type);
        $partenaire->setAdmin($admin);

        $this->entityManager->persist($partenaire);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/partenaire/update/{id}", name="update-partenaire", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $partenaire = $this->getDoctrine()->getManager()->getRepository(Partenaire::class)->findOneBy(['id'=>$id]);
        $logo=$request->get('logo');
        $type=$request->get('type');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $partenaire->setLogo(str_replace(' ', '+', $logo));
        $partenaire->setType($type);
        $partenaire->setAdmin($admin);

        $this->entityManager->persist($partenaire);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/partenaire/delete/{id}", name="delete_partenaire", methods={"POST"})
     */
    public function delete($id){
        $photoarchive = $this->getDoctrine()->getManager()->getRepository(Partenaire::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photoarchive);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }





}
