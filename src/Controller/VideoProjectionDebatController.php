<?php

namespace App\Controller;

use App\Entity\ProjectionDebat;
use App\Entity\VideoProjectionDebat;
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

class VideoProjectionDebatController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/video/projection/debat", name="video_projection_debat")
     */
    public function index(): Response
    {
        return $this->render('video_projection_debat/index.html.twig', [
            'controller_name' => 'VideoProjectionDebatController',
        ]);
    }

    /**
     * @Route("/videoprojectiondebat/getall" , methods={"POST"} , name="get-all-video-projection-debat")
     */
    public function getallvideoprojectionASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $videoprojectiondebat =$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\VideoProjectionDebat b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($videoprojectiondebat, null, ['groups' =>
            'videoprojectiondebat']);
        return $this->json($data, 200);
    }



    /**
     * @Route("/videoprojectiondebat/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_video_projection")
     */
    public function getphotobyid($id,$size="thumb.jpg"){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(VideoProjectionDebat::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'videoprojectiondebat1']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["photo"],0,22), "", $data["0"]["photo"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data["0"]["photo"], 200);
    }


    /**
     * @Route("/videoprojectiondebat/add", name="add-videoprojectiondebat", methods={"POST"})
     */
    public function add(Request $request)
    {
        $videoprojectiondebat = new VideoProjectionDebat();
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videoprojectiondebat->setPath($path);
        $videoprojectiondebat->setTitre($titre);
        $videoprojectiondebat->setDate($date);
        $videoprojectiondebat->setPhoto(str_replace(' ', '+', $photo));
        $videoprojectiondebat->setDescription($description);
        $videoprojectiondebat->setTitrear($titrear);
        $videoprojectiondebat->setDescriptionar($descriptionar);
        $this->entityManager->persist($videoprojectiondebat);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/videoprojectiondebat/update/{id}", name="update-videoprojectiondebat", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $videoprojectiondebat = $this->getDoctrine()->getManager()->getRepository(VideoProjectionDebat::class)->findOneBy(['id'=>$id]);
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videoprojectiondebat->setPath($path);
        $videoprojectiondebat->setTitre($titre);
        $videoprojectiondebat->setDate($date);
        $videoprojectiondebat->setPhoto(str_replace(' ', '+', $photo));
        $videoprojectiondebat->setDescription($description);
        $videoprojectiondebat->setTitrear($titrear);
        $videoprojectiondebat->setDescriptionar($descriptionar);
        $this->entityManager->persist($videoprojectiondebat);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }

    /**
     * @Route("/videoprojectiondebat/delete/{id}", name="delete_videoprojectiondebat", methods={"POST"})
     */
    public function delete($id){
        $videoprojectiondeabat = $this->getDoctrine()->getManager()->getRepository(VideoProjectionDebat::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($videoprojectiondeabat);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }



}
