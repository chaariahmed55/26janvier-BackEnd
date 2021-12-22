<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Brochure;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class BrochureController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/brochure", name="brochure")
     */
    public function index(): Response
    {
        return $this->render('brochure/index.html.twig', [
            'controller_name' => 'BrochureController',
        ]);
    }

    /**
     * @Route("/brochure/getall" , name="get-all-brochure-asc" ,methods={"POST"} )
     */
    public function getallbrochureASC(Request $request){
        $page=$request->get('page');
        $nbpage=$request->get('nbpage');
        $typeoftrie=$request->get('typeoftrie');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $brochure=$this->entityManager
            ->createQuery("SELECT b FROM App\Entity\Brochure b where 1=1 ORDER BY b.date ".$typeoftrie)
            ->setMaxResults($nbpage)
            ->setFirstResult($page*$nbpage)
            ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($brochure, null, ['groups' =>
            'brochure']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoBrochures"];
            if (count($photo) >0 ){
                $row["photoBrochures"]= $photo[0];
            }
            $newData[]= $row;
        }
        return $this->json($newData, 200);
    }

    /**
     * @Route("/brochure/add", name="add-brochure", methods={"POST"})
     */
    public function add(Request $request)
    {
        $brochure = new Brochure();
        $source=$request->get('source');
        $date=$request->get('date');
        $description=$request->get('description');
        $titre=$request->get('titre');
        $descriptionar=$request->get('descriptionar');
        $titrear=$request->get('titrear');
        $brochure->setSource($source);
        $brochure->setDate($date);
        $brochure->setDescription($description);
        $brochure->setTitre($titre);
        $brochure->setDescriptionar($descriptionar);
        $brochure->setTitrear($titrear);
        $this->entityManager->persist($brochure);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($brochure->getId(), 201);
    }

    /**
     * @Route("/brochure/update/{id}", name="update-brochure", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $brochure = $this->getDoctrine()->getManager()->getRepository(Brochure::class)->findOneBy(['id'=>$id]);
        $source=$request->get('source');
        $date=$request->get('date');
        $description=$request->get('description');
        $titre=$request->get('titre');
        $descriptionar=$request->get('descriptionar');
        $titrear=$request->get('titrear');
        $brochure->setSource($source);
        $brochure->setDate($date);
        $brochure->setDescription($description);
        $brochure->setTitre($titre);
        $brochure->setDescriptionar($descriptionar);
        $brochure->setTitrear($titrear);
        $this->entityManager->persist($brochure);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message,200);
    }

    /**
     * @Route("/brochure/delete/{id}", name="delete_brochure", methods={"POST"})
     */
    public function delete($id){
        $brochure = $this->getDoctrine()->getManager()->getRepository(Brochure::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($brochure);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }
}
