<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VideoArchive;
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


class VideoArchiveController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/video/archive", name="video_archive")
     */
    public function index(): Response
    {
        return $this->render('video_archive/index.html.twig', [
            'controller_name' => 'VideoArchiveController',
        ]);
    }

    /**
     * @Route("/videoarchive/getall" , methods={"POST"} , name="get-all-video-archive")
     */
    public function getallvideoarchiveASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users =$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\VideoArchive b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'videoarchive']);
        return $this->json($data, 200);
    }



    /**
     * @Route("/videoarchive/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_video_archive")
     */
    public function getphotobyid($id,$size="thumb.jpg"){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(VideoArchive::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'videoarchive1']);
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
     * @Route("/videoarchive/add", name="add-videoarchive", methods={"POST"})
     */
    public function add(Request $request)
    {
        $videoarchive=new VideoArchive();
        $path= $request->get('path');
        $photo=$request->get('photo');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videoarchive->setPath($path);
        $videoarchive->setPhoto(str_replace(' ', '+', $photo));
        $videoarchive->setTitre($titre);
        $videoarchive->setDate($date);
        $videoarchive->setDescription($description);
        $videoarchive->setPhoto(str_replace(' ', '+', $photo));
        $videoarchive->setTitrear($titrear);
        $videoarchive->setDescriptionar($descriptionar);

        $this->entityManager->persist($videoarchive);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }


    /**
     * @Route("/videoarchive/update/{id}", name="update-videoarchive", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $videoarchive = $this->getDoctrine()->getManager()->getRepository(VideoArchive::class)->findOneBy(['id'=>$id]);
        $path= $request->get('path');
        $photo=$request->get('photo');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videoarchive->setPath($path);
        $videoarchive->setPhoto(str_replace(' ', '+', $photo));
        $videoarchive->setTitre($titre);
        $videoarchive->setDate($date);
        $videoarchive->setDescription($description);
        $videoarchive->setPhoto(str_replace(' ', '+', $photo));
        $videoarchive->setTitrear($titrear);
        $videoarchive->setDescriptionar($descriptionar);
        $this->entityManager->persist($videoarchive);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }


    /**
     * @Route("/videoarchive/delete/{id}", name="delete_photoarchive", methods={"POST"})
     */
    public function delete($id){
        $videoarchive = $this->getDoctrine()->getManager()->getRepository(VideoArchive::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($videoarchive);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/videoarchive/getallbydate" , name="getvideoarchivebydate",  methods={"GET"})
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
                        from video_archive a 
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
