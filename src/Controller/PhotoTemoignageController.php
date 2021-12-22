<?php

namespace App\Controller;

use App\Entity\PhotoTemoignage;
use App\Entity\Temoignage;
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
use Imagick;



class PhotoTemoignageController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/temoignage", name="photo_temoignage")
     */
    public function index(): Response
    {
        return $this->render('photo_temoignage/index.html.twig', [
            'controller_name' => 'PhotoTemoignageController',
        ]);
    }


    /**
     * @Route("/phototemoignage/getall/{id}" , methods={"GET"} , name="gettallphototemoignage")
     */
    public function getalltemoignage($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $phototemoignage = $this->getDoctrine()->getManager()->getRepository(PhotoTemoignage::class)->findBy(['temoignage'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($phototemoignage, null, ['groups' =>
            'phototemoignage']);
        return $this->json($data, 200);
    }
    /**
     * @Route("/phototemoignage/getall/{id}/{size}" , methods={"GET"} , name="getphotophototemoignage")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $phototemoignage = $this->getDoctrine()->getManager()->getRepository(PhotoTemoignage::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($phototemoignage, null, ['groups' =>
            'phototemoignage']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["data"],0,22), "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data, 200);
    }

    /**
     * @Route("/phototemoignage/add", name="add-archive", methods={"POST"})
     */
    public function add(Request $request)
    {
        $phototemoignage = new PhotoTemoignage();
        $data=$request->get('data');
        $idtemoignage= $request->get('temoignage_id');
        $temoignage = $this->getDoctrine()->getManager()->getRepository(Temoignage::class)->findOneBy(['id'=>$idtemoignage]);
        if(!$temoignage){
            return $this->json('error',400);
        }
        $phototemoignage->setData(str_replace(' ', '+', $data));
        $phototemoignage->setTemoignage($temoignage);
        $this->entityManager->persist($phototemoignage);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/phototemoignage/update/{id}", name="update-phototemoignage", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $phototemoignage = $this->getDoctrine()->getManager()->getRepository(PhotoTemoignage::class)->findOneBy(['id'=>$id]);
        $data=$request->get('data');
        $idtemoignage= $request->get('temoignage_id');
        $temoignage = $this->getDoctrine()->getManager()->getRepository(Temoignage::class)->findOneBy(['id'=>$idtemoignage]);
        if(!$temoignage){
            return $this->json('error',400);
        }
        $phototemoignage->setData(str_replace(' ', '+', $data));
        $phototemoignage->setTemoignage($temoignage);
        $this->entityManager->persist($phototemoignage);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/phototemoignage/delete/{id}", name="delete_phototemoignage", methods={"POST"})
     */
    public function delete($id){
        $phototemoignage = $this->getDoctrine()->getManager()->getRepository(PhotoTemoignage::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($phototemoignage);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }








}
