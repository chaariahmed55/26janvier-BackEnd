<?php

namespace App\Controller;


use App\Entity\OtherResouce;
use App\Entity\User;
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


class OtherResourceController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/other/resource", name="other_resource")
     */
    public function index(): Response
    {
        return $this->render('other_resource/index.html.twig', [
            'controller_name' => 'OtherResourceController',
        ]);
    }

    /**
     * @Route("/or/getall" , methods={"POST"} , name="gettallotherresoucesASC")
     */
    public function getalluserASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact=$this->entityManager
            ->createQuery("SELECT o FROM App\Entity\OtherResouce o where 1=1 ORDER BY o.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($contact, null, ['groups' =>
            'otherresource']);
        return $this->json($data, 200);
    }


    /**
     * @Route("/or/get/{id}/{size}" , methods={"GET"} , name="get_thumb_photo_other_ressource")
     */
    public function getphotobyid($id,$size){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $photor = $this->getDoctrine()->getManager()->getRepository(OtherResouce::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($photor, null, ['groups' =>
            'otherresource1']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace(substr($data["0"]["data"],0,22), "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);}

        return $this->json($data["0"]["data"], 200);
    }


    /**
     * @Route("/or/add", name="add-or", methods={"POST"})
     */
    public function add(Request $request)
    {
        $otherresource = new OtherResouce();
        $link=$request->get('link');
        $data=$request->get('data');
        $date=$request->get('date');
        $titre=$request->get('titre');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $otherresource->setLink($link);
        $otherresource->setData(str_replace(' ', '+', $data));
        $otherresource->setDate($date);
        $otherresource->setTitre($titre);
        $otherresource->setDescription($description);
        $otherresource->setTitrear($titrear);
        $otherresource->setDescriptionar($descriptionar);
        $otherresource->setAdmin($admin);
        $this->entityManager->persist($otherresource);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }



    /**
     * @Route("/or/update/{id}", name="update-or", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $otherresource = $this->getDoctrine()->getManager()->getRepository(OtherResouce::class)->findOneBy(['id'=>$id]);
        $link=$request->get('link');
        $data=$request->get('data');
        $date=$request->get('date');
        $titre=$request->get('titre');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $otherresource->setLink($link);
        $otherresource->setData(str_replace(' ', '+', $data));
        $otherresource->setDate($date);
        $otherresource->setTitre($titre);
        $otherresource->setDescription($description);
        $otherresource->setTitrear($titrear);
        $otherresource->setDescriptionar($descriptionar);
        $otherresource->setAdmin($admin);
        $this->entityManager->persist($otherresource);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json('success',200);
    }



    /**
     * @Route("/or/delete/{id}", name="delete_or", methods={"POST"})
     */
    public function delete($id){
        $contact = $this->getDoctrine()->getManager()->getRepository(OtherResouce::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($contact);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }






}
