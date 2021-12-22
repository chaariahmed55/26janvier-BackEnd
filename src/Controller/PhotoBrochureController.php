<?php

namespace App\Controller;

use App\Entity\Brochure;
use App\Entity\PhotoBrochure;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Imagick;





class PhotoBrochureController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/brochure", name="photo_brochure")
     */
    public function index(): Response
    {
        return $this->render('photo_brochure/index.html.twig', [
            'controller_name' => 'PhotoBrochureController',
        ]);
    }

    /**
     * @Route("/photobrochure/getall/{id}" , methods={"GET"} , name="get_all_photo_brochure")
     */
    public function getallphotobrochure($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photobrochures = $this->getDoctrine()->getManager()->getRepository(PhotoBrochure::class)->findBy(['brochure'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photobrochures, null, ['groups' =>
            'photobrochure']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photobrochure/getall/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_brochure")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photobrochures = $this->getDoctrine()->getManager()->getRepository(PhotoBrochure::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photobrochures, null, ['groups' =>
            'photobrochure']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["data"],0,22), "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data, 200);    }


    /**
     * @Route("/photobrochure/add", name="add-photobrochure", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photobrochure=new PhotoBrochure();
        $data= $request->get('data');
        $idbrochure= $request->get('brochure_id');
        $brochure = $this->getDoctrine()->getManager()->getRepository(Brochure::class)->findOneBy(['id'=>$idbrochure]);
        if(!$brochure){
            return $this->json('error',400);
        }
        $photobrochure->setData(str_replace(' ', '+', $data));
        $photobrochure->setBrochure($brochure);
        $this->entityManager->persist($photobrochure);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photobrochure/update/{id}", name="update-photobrochure", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photobrochure = $this->getDoctrine()->getManager()->getRepository(PhotoBrochure::class)->findOneBy(['id'=>$id]);
        $data= $request->get('data');
        $idbrochure= $request->get('brochure_id');
        $brochure = $this->getDoctrine()->getManager()->getRepository(Brochure::class)->findOneBy(['id'=>$idbrochure]);
        if(!$brochure){
            return $this->json('error',400);
        }
        $photobrochure->setData(str_replace(' ', '+', $data));
        $photobrochure->setBrochure($brochure);
        $this->entityManager->persist($photobrochure);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/photobrochure/delete/{id}", name="delete_photobrochure", methods={"POST"})
     */
    public function delete($id){
        $photoarticle = $this->getDoctrine()->getManager()->getRepository(PhotoBrochure::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photoarticle);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }




}
