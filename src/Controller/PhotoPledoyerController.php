<?php

namespace App\Controller;

use App\Entity\PhotoPledoyer;
use App\Entity\Pledoyer;
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



class PhotoPledoyerController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/pledoyer", name="photo_pledoyer")
     */
    public function index(): Response
    {
        return $this->render('photo_pledoyer/index.html.twig', [
            'controller_name' => 'PhotoPledoyerController',
        ]);
    }

    /**
     * @Route("/photopledoyer/getall/{id}" , methods={"GET"} , name="photopledoyer")
     */
    public function getphotobyid($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photopledoyer = $this->getDoctrine()->getManager()->getRepository(PhotoPledoyer::class)->findBy(['pledoyer'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photopledoyer, null, ['groups' =>
            'photopledoyer']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photopledoyer/getall/{id}/{size}" , methods={"GET"} , name="thumbphotopledoyer")
     */
    public function getallarchive($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photopledoyer = $this->getDoctrine()->getManager()->getRepository(PhotoPledoyer::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photopledoyer, null, ['groups' =>
            'photopledoyer']);
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
     * @Route("/photopledoyer/add", name="add-photopledoyer", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photopledoyer = new PhotoPledoyer();
        $data=$request->get('data');
        $idpledoyer= $request->get('pledoyer_id');
        $pledoyer = $this->getDoctrine()->getManager()->getRepository(Pledoyer::class)->findOneBy(['id'=>$idpledoyer]);
        if(!$pledoyer){
            return $this->json('error',400);
        }
        $photopledoyer->setData(str_replace(' ', '+', $data));
        $photopledoyer->setPledoyer($pledoyer);
        $this->entityManager->persist($photopledoyer);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photopledoyer/update/{id}", name="update-photopledoyer", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photopledoyer = $this->getDoctrine()->getManager()->getRepository(PhotoPledoyer::class)->findOneBy(['id'=>$id]);
        $data=$request->get('data');
        $idpledoyer= $request->get('pledoyer_id');
        $pledoyer = $this->getDoctrine()->getManager()->getRepository(Pledoyer::class)->findOneBy(['id'=>$idpledoyer]);
        if(!$pledoyer){
            return $this->json('error',400);
        }
        $photopledoyer->setData(str_replace(' ', '+', $data));
        $photopledoyer->setPledoyer($pledoyer);
        $this->entityManager->persist($photopledoyer);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/photopledoyer/delete/{id}", name="delete_photopledoyer", methods={"POST"})
     */
    public function delete($id){
        $photopledoyer = $this->getDoctrine()->getManager()->getRepository(PhotoPledoyer::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photopledoyer);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }





}
