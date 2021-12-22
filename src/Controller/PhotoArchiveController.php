<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Entity\PhotoArchive;
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

class PhotoArchiveController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/photo/archive", name="photo_archive")
     */
    public function index(): Response
    {
        return $this->render('photo_archive/index.html.twig', [
            'controller_name' => 'PhotoArchiveController',
        ]);
    }

    /**
     * @Route("/photoarchive/getallbydate" , name="getallphotobydate" , methods={"GET"})
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
                        from photo_archive a 
                        where a.date BETWEEN '".$datedebut."' and '".$datefin."' ORDER BY a.date ".$typeoftrie."
                        LIMIT ".$nbpage." OFFSET ".$page ;
        $req = $this->entityManager->getConnection()->prepare($query);
        $req->execute();
        $articles = $req->fetchAllAssociative();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($articles, null, []);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photoarchive/getall" , methods={"POST"} , name="get-all-photoarchive-ASC")
     */
    public function getall(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photoarchive=$this->entityManager
            ->createQuery("SELECT o FROM App\Entity\PhotoArchive o where 1=1 ORDER BY o.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photoarchive, null, ['groups' =>
            'photoarchive']);
        return $this->json($data, 200);

    }

    /**
     * @Route("/photoarchive/getall/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_archive")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photoarchive = $this->getDoctrine()->getManager()->getRepository(PhotoArchive::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photoarchive, null, ['groups' =>
            'photoarchive1']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["data"],0,22), "", $data["0"]["data"]));
//            $image = base64_decode(str_replace("data:image/jpeg;base64", "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);}
        else if ($size=="full.jpg"){
            return $this->json($data["0"]["data"], 200);
        }
    }


    /**
     * @Route("/photoarchive/getallDESC" , methods={"GET"} , name="get-all-photoarchive-DESC")
     */
    public function getphotoarchiveDESC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photoarchive=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\PhotoArchive b where 1=1 ORDER BY b.date DESC")
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photoarchive, null, ['groups' =>
            'photoarchive']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/photoarchive/add", name="add-photoarchive", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photoarchive=new PhotoArchive();
        $data= $request->get('data');
        $description=$request->get('description');
        $name=$request->get('name');
        $descriptionar=$request->get('descriptionar');
        $namear=$request->get('namear');
        $date=$request->get('date');
        $source=$request->get('source');
        $photoarchive->setData(str_replace(' ', '+', $data));
        $photoarchive->setDescription($description);
        $photoarchive->setName($name);
        $photoarchive->setDescriptionar($descriptionar);
        $photoarchive->setNamear($namear);
        $photoarchive->setDate($date);
        $photoarchive->setSource($source);
        $this->entityManager->persist($photoarchive);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photoarchive/update/{id}", name="update-photoarchive", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photoarchive = $this->getDoctrine()->getManager()->getRepository(PhotoArchive::class)->findOneBy(['id'=>$id]);
        $data= $request->get('data');
        $description=$request->get('description');
        $name=$request->get('name');
        $descriptionar=$request->get('descriptionar');
        $namear=$request->get('namear');
        $date=$request->get('date');
        $source=$request->get('source');
        $photoarchive->setData(str_replace(' ', '+', $data));
        $photoarchive->setDescription($description);
        $photoarchive->setName($name);
        $photoarchive->setDescriptionar($descriptionar);
        $photoarchive->setNamear($namear);
        $photoarchive->setDate($date);
        $photoarchive->setSource($source);
        $this->entityManager->persist($photoarchive);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }

    /**
     * @Route("/photoarchive/delete/{id}", name="delete_photo_archive", methods={"POST"})
     */
    public function delete($id){
        $photoarchive = $this->getDoctrine()->getManager()->getRepository(PhotoArchive::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photoarchive);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }






}
