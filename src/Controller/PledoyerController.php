<?php

namespace App\Controller;

use App\Entity\Pledoyer;
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


class PledoyerController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/pledoyer", name="pledoyer")
     */
    public function index(): Response
    {
        return $this->render('pledoyer/index.html.twig', [
            'controller_name' => 'PledoyerController',
        ]);
    }

    /**
     * @Route("/pledoyer/getall" , methods={"POST"} , name="get-all-pledoyer")
     */
    public function getallpledoyerDESC(Request $request){
        $page=$request->get('page');
        $type=$request->get('type');
        $nbparpage=$request->get('nbparpage');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $pledoyer=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\Pledoyer b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($pledoyer, null, ['groups' =>
            'pledoyer']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoPledoyers"];
            if (count($photo) >0 ){
                $row["photoPledoyers"]= $photo[0];
            }
            $newData[]= $row;
        }

        return $this->json($newData, 200);
    }


    /**
     * @Route("/pledoyer/add", name="add-pledoyer", methods={"POST"})
     */
    public function add(Request $request)
    {
        $pledoyer = new Pledoyer();
        $description=$request->get('description');
        $titre=$request->get('titre');
        $source=$request->get('source');
        $titrear=$request->get('titrear');
        $descriptionar=$request->get('descriptionar');
        $date=$request->get('date');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $pledoyer->setDescription($description);
        $pledoyer->setTitre($titre);
        $pledoyer->setDescriptionar($descriptionar);
        $pledoyer->setTitrear($titrear);
        $pledoyer->setSource($source);
        $pledoyer->setDate($date);
        $pledoyer->setAdmin($admin);
        $this->entityManager->persist($pledoyer);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($pledoyer->getId(), 201);
    }

    /**
     * @Route("/pledoyer/update/{id}", name="update-pledoyer", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $pledoyer = $this->getDoctrine()->getManager()->getRepository(Pledoyer::class)->findOneBy(['id'=>$id]);
        $description=$request->get('description');
        $titre=$request->get('titre');
        $descriptionar=$request->get('descriptionar');
        $titrear=$request->get('titrear');
        $source=$request->get('source');
        $date=$request->get('date');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $pledoyer->setDescription($description);
        $pledoyer->setTitre($titre);
        $pledoyer->setDescriptionar($descriptionar);
        $pledoyer->setTitrear($titrear);
        $pledoyer->setSource($source);
        $pledoyer->setDate($date);
        $pledoyer->setAdmin($admin);
        $this->entityManager->persist($pledoyer);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/pledoyer/delete/{id}", name="delete_pledoyer", methods={"POST"})
     */
    public function delete($id){
        $pledoyer = $this->getDoctrine()->getManager()->getRepository(Pledoyer::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($pledoyer);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/pledoyer/getallbydate" , name="pledoyer-get-by-date" ,methods={"GET"} )
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
                        from pledoyer a 
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
