<?php

namespace App\Controller;

use App\Entity\Pledoyer;
use App\Entity\VideoPledoyer;
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


class VideoPledoyerController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/video/pledoyer", name="video_pledoyer")
     */
    public function index(): Response
    {
        return $this->render('video_pledoyer/index.html.twig', [
            'controller_name' => 'VideoPledoyerController',
        ]);
    }

    /**
     * @Route("/videopledoyer/getall" , methods={"POST"} , name="get-all-video-pledoyer")
     */
    public function getallarchiveASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $videopledoyer =$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\VideoPledoyer b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($videopledoyer, null, ['groups' =>
            'videopledoyer']);
        return $this->json($data, 200);
    }



    /**
     * @Route("/videopledoyer/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_video_pledoyer")
     */
    public function getphotobyid($id,$size="thumb.jpg"){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(VideoPledoyer::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'videopledoyer1']);
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
     * @Route("/videopledoyer/add", name="add-videopledoyer", methods={"POST"})
     */
    public function add(Request $request)
    {
        $videopledoyer = new VideoPledoyer();
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');

        $videopledoyer->setPath($path);
        $videopledoyer->setTitre($titre);
        $videopledoyer->setDate($date);
        $videopledoyer->setPhoto(str_replace(' ', '+', $photo));
        $videopledoyer->setDescription($description);
        $videopledoyer->setDescriptionar($descriptionar);
        $videopledoyer->setTitrear($titrear);

        $this->entityManager->persist($videopledoyer);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }






    /**
     * @Route("/videopledoyer/update/{id}", name="update-videopledoyer", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $videopledoyer = $this->getDoctrine()->getManager()->getRepository(VideoPledoyer::class)->findOneBy(['id'=>$id]);
        $path=$request->get('path');
        $titre=$request->get('titre');
        $date=$request->get('date');
        $photo=$request->get('photo');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $videopledoyer->setPath($path);
        $videopledoyer->setTitre($titre);
        $videopledoyer->setDate($date);
        $videopledoyer->setPhoto(str_replace(' ', '+', $photo));
        $videopledoyer->setDescription($description);
        $videopledoyer->setDescriptionar($descriptionar);
        $videopledoyer->setTitrear($titrear);
        $this->entityManager->persist($videopledoyer);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }

    /**
     * @Route("/videopledoyer/delete/{id}", name="delete_videopledoyer", methods={"POST"})
     */
    public function delete($id){
        $videopledoyer = $this->getDoctrine()->getManager()->getRepository(VideoPledoyer::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($videopledoyer);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }

}
