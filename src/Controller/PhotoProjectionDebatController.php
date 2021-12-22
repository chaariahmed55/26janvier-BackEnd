<?php

namespace App\Controller;

use App\Entity\PhotoProjectionDebat;
use App\Entity\ProjectionDebat;
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


class PhotoProjectionDebatController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/projection/debat", name="photo_projection_debat")
     */
    public function index(): Response
    {
        return $this->render('photo_projection_debat/index.html.twig', [
            'controller_name' => 'PhotoProjectionDebatController',
        ]);
    }


    /**
     * @Route("/photoprojectiondebat/getall/{id}" , methods={"GET"} , name="gettallphotoprojectiondebat")
     */
    public function getallarchive($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photoprojectiondebat = $this->getDoctrine()->getManager()->getRepository(PhotoProjectionDebat::class)->findBy(['projectiondebat'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photoprojectiondebat, null, ['groups' =>
            'photoprojectiondebat']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photoprojectiondebat/getall/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_projectiondebat")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photoprojectiondebat = $this->getDoctrine()->getManager()->getRepository(PhotoProjectionDebat::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photoprojectiondebat, null, ['groups' =>
            'photoprojectiondebat']);
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
     * @Route("/photoprojectiondebat/add", name="add-photoprojectiondebat", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(Request $request)
    {
        $photoprojectiondebat = new PhotoProjectionDebat();
        $data=$request->get('data');
        $idprojectiondebat= $request->get('projectiondebat_id');
        $projectiondebat = $this->getDoctrine()->getManager()->getRepository(ProjectionDebat::class)->findOneBy(['id'=>$idprojectiondebat]);
        if(!$projectiondebat){
            return $this->json('error',400);
        }
        $photoprojectiondebat->setData(str_replace(' ', '+', $data));

        $photoprojectiondebat->setProjectiondebat($projectiondebat);
        $this->entityManager->persist($photoprojectiondebat);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photoprojectiondebat/update/{id}", name="update-photoprojectiondebat", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photoprojectiondebat = $this->getDoctrine()->getManager()->getRepository(PhotoProjectionDebat::class)->findOneBy(['id'=>$id]);
        $data=$request->get('data');
        $idprojectiondebat= $request->get('projectiondebat_id');
        $projectiondebat = $this->getDoctrine()->getManager()->getRepository(ProjectionDebat::class)->findOneBy(['id'=>$idprojectiondebat]);
        if(!$projectiondebat){
            return $this->json('error',400);
        }
        $photoprojectiondebat->setData(str_replace(' ', '+', $data));
        $photoprojectiondebat->setProjectiondebat($projectiondebat);
        $this->entityManager->persist($photoprojectiondebat);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/photoprojectiondebat/delete/{id}", name="delete_photoprojectiondebat", methods={"POST"})
     */
    public function delete($id){
        $photoprojectiondebat = $this->getDoctrine()->getManager()->getRepository(PhotoProjectionDebat::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photoprojectiondebat);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }
















}
