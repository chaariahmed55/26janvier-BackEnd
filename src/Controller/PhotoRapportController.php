<?php

namespace App\Controller;

use App\Entity\PhotoRapport;
use App\Entity\Rapport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Imagick;



class PhotoRapportController extends AbstractController
{
    /**
     * @Route("/photo/rapport", name="photo_rapport")
     */
    public function index(): Response
    {
        return $this->render('photo_rapport/index.html.twig', [
            'controller_name' => 'PhotoRapportController',
        ]);
    }
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photorapport/getall/{id}" , methods={"GET"} , name="getallphotorapport")
     */
    public function getallphotoarticle($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photobrochures = $this->getDoctrine()->getManager()->getRepository(PhotoRapport::class)->findBy(['rapport'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photobrochures, null, ['groups' =>
            'photorapport']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photorapport/getall/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_rapport")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photobrochures = $this->getDoctrine()->getManager()->getRepository(PhotoRapport::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photobrochures, null, ['groups' =>
            'photorapport']);
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
     * @Route("/photorapport/add", name="add-photo-rapport", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photorapport=new PhotoRapport();
        $data= $request->get('data');
        $idrapport= $request->get('rapport_id');
        $rapport = $this->getDoctrine()->getManager()->getRepository(Rapport::class)->findOneBy(['id'=>$idrapport]);
        if(!$rapport){
            return $this->json('error',400);
        }
        $photorapport->setData(str_replace(' ', '+', $data));
        $photorapport->setRapport($rapport);
        $this->entityManager->persist($photorapport);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photorapport/update/{id}", name="update-photorapport", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photorapport = $this->getDoctrine()->getManager()->getRepository(PhotoRapport::class)->findOneBy(['id'=>$id]);
        $data= $request->get('data');
        $idrapport= $request->get('rapport_id');
        $rapport = $this->getDoctrine()->getManager()->getRepository(Rapport::class)->findOneBy(['id'=>$idrapport]);
        if(!$rapport){
            return $this->json('error',400);
        }
        $photorapport->setData(str_replace(' ', '+', $data));
        $photorapport->setRapport($rapport);
        $this->entityManager->persist($photorapport);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/photorapport/delete/{id}", name="delete_photorapport", methods={"POST"})
     */
    public function delete($id){
        $photorapport = $this->getDoctrine()->getManager()->getRepository(PhotoRapport::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photorapport);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }








}
