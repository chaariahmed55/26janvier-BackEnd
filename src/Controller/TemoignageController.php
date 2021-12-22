<?php

namespace App\Controller;

use App\Entity\Temoignage;
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

class TemoignageController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/temoignage", name="temoignage")
     */
    public function index(): Response
    {
        return $this->render('temoignage/index.html.twig', [
            'controller_name' => 'TemoignageController',
        ]);
    }

    /**
     * @Route("/temoignage/getall" , methods={"POST"} , name="get-all-temoignage")
     */
    public function getallarchiveASC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $temoignage=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\Temoignage b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($temoignage, null, ['groups' =>
            'temoignage']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoTemoignages"];
            if (count($photo) >0 ){
                $row["photoTemoignages"]= $photo[0];
            }
            $newData[]= $row;
        }

        return $this->json($newData, 200);
    }




    /**
     * @Route("/temoignage/add", name="add-temoignage", methods={"POST"})
     */
    public function add(Request $request)
    {
        $temoignage = new Temoignage();
        $date=$request->get('date');
        $source=$request->get('source');
        $titre=$request->get('titre');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $temoignage->setDate($date);
        $temoignage->setSource($source);
        $temoignage->setTitre($titre);
        $temoignage->setDescription($description);
        $temoignage->setTitrear($titrear);
        $temoignage->setDescriptionar($descriptionar);
        $temoignage->setAdmin($admin);
        $this->entityManager->persist($temoignage);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($temoignage->getId(), 201);
    }

    /**
     * @Route("/temoignage/update/{id}", name="update-temoignage", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $temoignage = $this->getDoctrine()->getManager()->getRepository(Temoignage::class)->findOneBy(['id'=>$id]);
        $date=$request->get('date');
        $source=$request->get('source');
        $titre=$request->get('titre');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $temoignage->setDate($date);
        $temoignage->setSource($source);
        $temoignage->setTitre($titre);
        $temoignage->setDescription($description);
        $temoignage->setTitrear($titrear);
        $temoignage->setDescriptionar($descriptionar);
        $temoignage->setAdmin($admin);
        $this->entityManager->persist($temoignage);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/temoignage/delete/{id}", name="delete_temoignage", methods={"POST"})
     */
    public function delete($id){
        $temoignage = $this->getDoctrine()->getManager()->getRepository(Temoignage::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($temoignage);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/temoignage/getallbydate" , name="temoignage-get-by-date" ,methods={"GET"} )
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
                        from temoignage a 
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
