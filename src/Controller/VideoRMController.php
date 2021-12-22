<?php

namespace App\Controller;

use App\Entity\RetombeMediatique;
use App\Entity\VideoRM;
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


class VideoRMController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/video/r/m", name="video_r_m")
     */
    public function index(): Response
    {
        return $this->render('video_rm/index.html.twig', [
            'controller_name' => 'VideoRMController',
        ]);
    }


    /**
     * @Route("/videorm/getall" , methods={"POST"} , name="get-videorm-ASC")
     */
    public function getallvideormASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $videorm =$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\VideoRM b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($videorm, null, ['groups' =>
            'videorm']);
        return $this->json($data, 200);
    }


    /**
     * @Route("/videorm/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_video_retombe_mediatique")
     */
    public function getphotobyid($id,$size="thumb.jpg"){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(VideoRM::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'videorm1']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["photo"],0,22), "", $data["0"]["photo"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(200,82,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data["0"]["photo"], 200);
    }

    /**
     * @Route("/videorm/add", name="add-videorm", methods={"POST"})
     */
    public function add(Request $request)
    {
        $videorm = new VideoRM();

        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');

        $videorm->setPath($path);
        $videorm->setTitre($titre);
        $videorm->setDate($date);
        $videorm->setPhoto(str_replace(' ', '+', $photo));
        $videorm->setDescription($description);
        $videorm->setTitrear($titrear);
        $videorm->setDescriptionar($descriptionar);

        $this->entityManager->persist($videorm);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/videorm/update/{id}", name="update-videorm", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $videorm = $this->getDoctrine()->getManager()->getRepository(VideoRM::class)->findOneBy(['id'=>$id]);
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');

        $videorm->setPath($path);
        $videorm->setTitre($titre);
        $videorm->setDate($date);
        $videorm->setPhoto(str_replace(' ', '+', $photo));
        $videorm->setDescription($description);
        $videorm->setTitrear($titrear);
        $videorm->setDescriptionar($descriptionar);

        $this->entityManager->persist($videorm);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }

    /**
     * @Route("/videorm/delete/{id}", name="delete_videorm", methods={"POST"})
     */
    public function delete($id){
        $videorm = $this->getDoctrine()->getManager()->getRepository(VideoRM::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($videorm);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/videorm/getallbydate" , name="get-video-bydate",  methods={"GET"})
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
                        from video_rm a 
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

