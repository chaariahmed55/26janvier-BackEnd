<?php

namespace App\Controller;

use App\Entity\PhotoRM;
use App\Entity\RetombeMediatique;
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



class PhotoRMController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/r/m", name="photo_r_m")
     */
    public function index(): Response
    {
        return $this->render('photo_rm/index.html.twig', [
            'controller_name' => 'PhotoRMController',
        ]);
    }


    /**
     * @Route("/photorm/getall/{id}" , methods={"GET"} , name="getphotorm")
     */
    public function getallphotorm($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photorm = $this->getDoctrine()->getManager()->getRepository(PhotoRM::class)->findBy(['retombeMediatique'=>$id]);;
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photorm, null, ['groups' =>
            'photorm']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photorm/getall/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_rm")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photorm = $this->getDoctrine()->getManager()->getRepository(PhotoRM::class)->findBy(['id'=>$id]);;
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photorm, null, ['groups' =>
            'photorm']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["data"],0,22), "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(200,82,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data, 200);    }

    /**
     * @Route("/photorm/add", name="add-photorm", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photorm = new PhotoRM();
        $data=$request->get('data');
        $idretombemediatique= $request->get('retombemediatique_id');
        $retombemediatique = $this->getDoctrine()->getManager()->getRepository(RetombeMediatique::class)->findOneBy(['id'=>$idretombemediatique]);
        if(!$retombemediatique){
            return $this->json('error',400);
        }
        $photorm->setData(str_replace(' ', '+', $data));
        $photorm->setRetombemediatique($retombemediatique);
        $this->entityManager->persist($photorm);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photorm/update/{id}", name="update-photorm", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photorm = $this->getDoctrine()->getManager()->getRepository(PhotoRM::class)->findOneBy(['id'=>$id]);
        $data=$request->get('data');
        $idretombemediatique= $request->get('retombemediatique_id');
        $retombemediatique = $this->getDoctrine()->getManager()->getRepository(RetombeMediatique::class)->findOneBy(['id'=>$idretombemediatique]);
        if(!$retombemediatique){
            return $this->json('error',400);
        }
        $photorm->setData(str_replace(' ', '+', $data));
        $photorm->setRetombemediatique($retombemediatique);
        $this->entityManager->persist($photorm);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/photorm/delete/{id}", name="delete_photorm", methods={"POST"})
     */
    public function delete($id){
        $photorm = $this->getDoctrine()->getManager()->getRepository(PhotoRM::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photorm);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }



    /**
     * @Route("/photorm/getallbydate" , name="get-photorm-bydate",  methods={"GET"})
     */
    public function getbydate(Request $request)
    {
        $datedebut = $request->get('datedebut');
        $datefin = $request->get('datefin');
        $typeoftrie=$request->get('typeoftrie');
        $nbpage = $request->get('nbpage');
        $page = $request->get('page');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $query = "      select a.* 
                        from photo_rm a 
                        LIMIT ".$nbpage." OFFSET ".$page ;
        $req = $this->entityManager->getConnection()->prepare($query);
        $req->execute();
        $articles = $req->fetchAllAssociative();
        dump($articles);die;
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($articles, null, []);
        return $this->json($data, 200);
    }







}
