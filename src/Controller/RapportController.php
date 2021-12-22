<?php

namespace App\Controller;
use App\Entity\Rapport;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Imagick;


class RapportController extends AbstractController
{
    /**
     * @Route("/rapport", name="rapport")
     */
    public function index(): Response
    {
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
        ]);
    }

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rapport/getall" , methods={"POST"} , name="get_all_rapport")
     */
    public function getallrapport(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $brochure=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\Rapport b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($brochure, null, ['groups' =>
            'rapport']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoRapports"];
            if (count($photo) >0 ){
                $row["photoRapports"]= $photo[0];
            }
            $newData[]= $row;
        }

        return $this->json($newData, 200);
    }


    /**
     * @Route("/rapport/add", name="add-rapport", methods={"POST"})
     */
    public function add(Request $request)
    {
        $rapport = new Rapport();
        $source=$request->get('source');
        $titre=$request->get('titre');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $data=$request->get('date');
        $rapport->setSource($source);
        $rapport->setTitre($titre);
        $rapport->setDescription($description);
        $rapport->setTitrear($titrear);
        $rapport->setDescriptionar($descriptionar);
        $rapport->setDate($data);
        $this->entityManager->persist($rapport);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($rapport->getId(), 201);
    }

    /**
     * @Route("/rapport/update/{id}", name="update-rapport", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $rapport = $this->getDoctrine()->getManager()->getRepository(Rapport::class)->findOneBy(['id'=>$id]);
        $source=$request->get('source');
        $titre=$request->get('titre');
        $description=$request->get('description');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $data=$request->get('date');
        $rapport->setSource($source);
        $rapport->setTitre($titre);
        $rapport->setDescription($description);
        $rapport->setTitrear($titrear);
        $rapport->setDescriptionar($descriptionar);
        $rapport->setDate($data);
        $this->entityManager->persist($rapport);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/rapport/delete/{id}", name="delete_rapport", methods={"POST"})
     */
    public function delete($id){
        $rapport = $this->getDoctrine()->getManager()->getRepository(Rapport::class)->findOneBy(['id'=>$id]);
        $this->entityManager->remove($rapport);
        $this->entityManager->flush();
        return $this->json('success remove',200);
    }



    /**
     * @Route("/rapport/getallbydate" , name="getallrapport" , methods={"GET"})
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
                        from rapport a 
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
