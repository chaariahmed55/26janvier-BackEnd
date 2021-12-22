<?php

namespace App\Controller;


use App\Entity\Temoignage;
use App\Entity\VideoTemoignage;
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


class VideoTemoignageController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/video/temoignage", name="video_temoignage")
     */
    public function index(): Response
    {
        return $this->render('video_temoignage/index.html.twig', [
            'controller_name' => 'VideoTemoignageController',
        ]);
    }


    /**
     * @Route("/videotemoignage/getall" , methods={"POSt"} , name="get-all-video-temoignage")
     */
    public function getalltemoignageDESC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $videotemoignage =$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\VideoTemoignage b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($videotemoignage, null, ['groups' =>
            'videotemoignage']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/videotemoignage/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_video_temoignage")
     */
    public function getphotobyid($id,$size="thumb.jpg"){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(VideoTemoignage::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'videotemoignage1']);
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
     * @Route("/videotemoignage/add", name="add-video-video-temoignage", methods={"POST"})
     */
    public function add(Request $request)
    {
        $videotemoignage = new VideoTemoignage();
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videotemoignage->setPath($path);
        $videotemoignage->setTitre($titre);
        $videotemoignage->setDate($date);
        $videotemoignage->setPhoto(str_replace(' ', '+', $photo));
        $videotemoignage->setDescription($description);
        $videotemoignage->setTitrear($titrear);
        $videotemoignage->setDescriptionar($descriptionar);
        $this->entityManager->persist($videotemoignage);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/videotemoignage/update/{id}", name="update-videotemoignage", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $videotemoignage = $this->getDoctrine()->getManager()->getRepository(VideoTemoignage::class)->findOneBy(['id'=>$id]);
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videotemoignage->setPath($path);
        $videotemoignage->setTitre($titre);
        $videotemoignage->setDate($date);
        $videotemoignage->setPhoto(str_replace(' ', '+', $photo));
        $videotemoignage->setDescription($description);
        $videotemoignage->setTitrear($titrear);
        $videotemoignage->setDescriptionar($descriptionar);

        $this->entityManager->persist($videotemoignage);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }

    /**
     * @Route("/videotemoignage/delete/{id}", name="delete_videotemoignage", methods={"POST"})
     */
    public function delete($id){
        $videotemoignage = $this->getDoctrine()->getManager()->getRepository(VideoTemoignage::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($videotemoignage);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }











}
