<?php

namespace App\Controller;

use App\Entity\Programme;
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
use Imagick;

class ProgrammeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/programme", name="programme")
     */
    public function index(): Response
    {
        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }

    /**
     * @Route("/programme/getall" , methods={"POST"} , name="get_programme_sorted_paginated")
     */
    public function getallprogrammeASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $programme=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\Programme b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($programme, null, ['groups' =>
            'programme']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/programme/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_programme")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photor = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photor, null, ['groups' =>
            'photoprogramme']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["data"],0,22), "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data["0"]["data"], 200);
    }

    /**
     * @Route("/programme/add", name="add-programme", methods={"POST"})
     */
    public function add(Request $request)
    {
        $programme = new Programme();
        $date= $request->get('date');
        $adresse=$request->get('adresse');
        $title=$request->get('title');
        $categorie=$request->get('categorie');
        $description=$request->get('description');
        $data=$request->get('data');
        $adressear=$request->get('adressear');
        $titlear=$request->get('titlear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $programme->setDate($date);
        $programme->setAdresse($adresse);
        $programme->setTitle($title);
        $programme->setCategorie($categorie);
        $programme->setData(str_replace(' ', '+', $data));
        $programme->setDescription($description);
        $programme->setAdmin($admin);
        $programme->setAdressear($adressear);
        $programme->setTitlear($titlear);
        $programme->setDescriptionar($descriptionar);
        $this->entityManager->persist($programme);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/programme/update/{id}", name="update-programme", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$id]);
        $date= $request->get('date');
        $adresse=$request->get('adresse');
        $title=$request->get('title');
        $categorie=$request->get('categorie');
        $description=$request->get('description');
        $data=$request->get('data');
        $adressear=$request->get('adressear');
        $titlear=$request->get('titlear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $programme->setDate($date);
        $programme->setAdresse($adresse);
        $programme->setTitle($title);
        $programme->setCategorie($categorie);
        $programme->setData(str_replace(' ', '+', $data));
        $programme->setDescription($description);
        $programme->setAdmin($admin);
        $programme->setAdressear($adressear);
        $programme->setTitlear($titlear);
        $programme->setDescriptionar($descriptionar);
        $this->entityManager->persist($programme);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/programme/delete/{id}", name="delete_programme", methods={"POST"} )
     */
    public function delete($id){
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($programme);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }

    /**
     * @Route("/programme/getone/{id}", name="get_one_by_id", methods={"GET"})
     */
    public function getoneby($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $programme = $this->getDoctrine()->getManager()->getRepository(Programme::class)->findOneBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($programme, null, ['groups' =>
            'programme']);
        return $this->json($data,200);
    }



//
//    /**
//     * @Route("/programme/getallbydate" , name="getallusers")
//     */
//    public function getbydate(Request $request)
//    {
//        $datedebut = $request->get('datedebut');
//        $datefin = $request->get('datefin');
//        $typeoftrie=$request->get('typeoftrie');
//        $nbpage = $request->get('nbpage');
//        $page = $request->get('page');
//        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
//        $query = "      select p.*
//                        from Programme p
//                        where p.date BETWEEN '".$datedebut."' and '".$datefin."' ORDER BY p.date ".$typeoftrie."
//                        LIMIT ".$nbpage." OFFSET ".$page ;
//        $req = $this->entityManager->getConnection()->prepare($query);
//        $req->execute();
//        $articles = $req->fetchAllAssociative();
//        dump($articles);die;
//        $normalizer = new ObjectNormalizer($classMetadataFactory);
//        $serializer = new Serializer([$normalizer]);
//        $data = $serializer->normalize($articles, null, []);
//        return $this->json($data, 200);
//    }







}
