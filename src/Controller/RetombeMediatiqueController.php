<?php

namespace App\Controller;

use App\Entity\RetombeMediatique;
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

class RetombeMediatiqueController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/retombe/mediatique", name="retombe_mediatique")
     */
    public function index(): Response
    {
        return $this->render('retombe_mediatique/index.html.twig', [
            'controller_name' => 'RetombeMediatiqueController',
        ]);
    }

    /**
     * @Route("/retombemediatique/getall" , methods={"POST"} , name="get-all-retombe-mediatique")
     */
    public function getallretombemediatiqueASC(Request $request){
        $page=$request->get('page');
        $nbparpage=$request->get('nbparpage');
        $type=$request->get('type');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $retombemediatique =$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\RetombeMediatique b where 1=1 ORDER BY b.date ".$type)
            ->setMaxResults($nbparpage)
            ->setFirstResult($page*$nbparpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($retombemediatique, null, ['groups' =>
            'retombemediatique']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoRM"];
            if (count($photo) >0 ){
                $row["photoRM"]= $photo[0];
            }
            $newData[]= $row;
        }
        return $this->json($newData, 200);
    }




    /**
     * @Route("/retombemediatique/add", name="add-retombemediatique", methods={"POST"})
     */
    public function add(Request $request)
    {
        $retombemediatique = new RetombeMediatique();
        $legende= $request->get('legende');
        $title= $request->get('title');
        $autor= $request->get('author');
        $idadmin= $request->get('admin_id');
        $legendear= $request->get('legendear');
        $titlear= $request->get('titlear');
        $source= $request->get('source');
        $date= $request->get('date');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $retombemediatique->setLegende($legende);
        $retombemediatique->setTitle($title);
        $retombemediatique->setLegendear($legendear);
        $retombemediatique->setTitlear($titlear);
        $retombemediatique->setDate($date);
        $retombemediatique->setAuthor($autor);
        $retombemediatique->setSource($source);
        $retombemediatique->setAdmin($admin);
        $this->entityManager->persist($retombemediatique);
        $this->entityManager->flush();
        $retombemediatique->getId();
//        $message = [
//            'satus' => 201,
//            'message' => 'success'
//        ];
        return $this->json($retombemediatique->getId(), 201);
    }

    /**
     * @Route("/retombemediatique/update/{id}", name="update-$retombemediatique", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $retombemediatique = $this->getDoctrine()->getManager()->getRepository(RetombeMediatique::class)->findOneBy(['id'=>$id]);
        $legende= $request->get('legende');
        $title= $request->get('title');
        $autor= $request->get('author');
        $idadmin= $request->get('admin_id');
        $source= $request->get('source');
        $date= $request->get('date');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $retombemediatique->setLegende($legende);
        $retombemediatique->setTitle($title);
        $retombemediatique->setDate($date);
        $retombemediatique->setAuthor($autor);
        $retombemediatique->setSource($source);
        $retombemediatique->setAdmin($admin);
        $this->entityManager->persist($retombemediatique);
        $this->entityManager->flush();
        $retombemediatique->getId();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/retombemediatique/delete/{id}", name="delete_$retombemediatique", methods={"POST"})
     */
    public function delete($id){
        $retombemediatique = $this->getDoctrine()->getManager()->getRepository(RetombeMediatique::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($retombemediatique);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }



}
