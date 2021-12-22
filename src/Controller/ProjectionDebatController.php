<?php

namespace App\Controller;

use App\Entity\ProjectionDebat;
use App\Entity\User;
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

class ProjectionDebatController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/projection/debat", name="projection_debat")
     */
    public function index(): Response
    {
        return $this->render('projection_debat/index.html.twig', [
            'controller_name' => 'ProjectionDebatController',
        ]);
    }

    /**
     * @Route("/projectiondebat/getall" , methods={"POST"} , name="gett-all-projection-debat")
     */
    public function getallprojectiondebatDESC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $projectiondebat=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\ProjectionDebat b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($projectiondebat, null, ['groups' =>
            'projectiondebat']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoProjectionDebats"];
            if (count($photo) >0 ){
                $row["photoProjectionDebats"]= $photo[0];
            }
            $newData[]= $row;
        }
        return $this->json($newData, 200);
    }


    /**
     * @Route("/projectiondebat/add", name="add-projectiondebat", methods={"POST"})
     */
    public function add(Request $request)
    {
        $projectiondebat = new ProjectionDebat();
        $date= $request->get('date');
        $title=$request->get('title');
        $description=$request->get('description');
        $source=$request->get('source');
        $idadmin= $request->get('admin_id');
        $titlear=$request->get('titlear');
        $descriptionar=$request->get('descriptionar');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $projectiondebat->setDate($date);
        $projectiondebat->setTitle($title);
        $projectiondebat->setSource($source);
        $projectiondebat->setDescription($description);
        $projectiondebat->setAdmin($admin);
        $projectiondebat->setTitlear($titlear);
        $projectiondebat->setDescriptionar($descriptionar);
        $this->entityManager->persist($projectiondebat);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($projectiondebat->getId(), 201);
    }

    /**
     * @Route("/projectiondebat/update/{id}", name="update-projectiondebat", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $projectiondebat = $this->getDoctrine()->getManager()->getRepository(ProjectionDebat::class)->findOneBy(['id'=>$id]);
        $date= $request->get('date');
        $title=$request->get('title');
        $description=$request->get('description');
        $source=$request->get('source');
        $titlear=$request->get('titlear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $projectiondebat->setDate($date);
        $projectiondebat->setTitle($title);
        $projectiondebat->setSource($source);
        $projectiondebat->setDescription($description);
        $projectiondebat->setTitlear($titlear);
        $projectiondebat->setDescriptionar($descriptionar);
        $projectiondebat->setAdmin($admin);
        $this->entityManager->persist($projectiondebat);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/projectiondebat/delete/{id}", name="delete_projectiondebat", methods={"POST"})
     */
    public function delete($id){
        $projectiondebat = $this->getDoctrine()->getManager()->getRepository(ProjectionDebat::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($projectiondebat);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/projectiondebat/getallbydate" , name="projection-debat-get-by-date" ,methods={"GET"} )
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
                        from projection_debat a 
                        where a.date BETWEEN '".$datedebut."' and '".$datefin."' ORDER BY a.date ".$typeoftrie."
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
