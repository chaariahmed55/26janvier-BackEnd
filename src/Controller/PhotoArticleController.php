<?php

namespace App\Controller;

use Imagick;
use App\Entity\Article;
use App\Entity\PhotoArticle;
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

class PhotoArticleController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/photo/article", name="photo_article")
     */
    public function index(): Response
    {
        return $this->render('photo_article/index.html.twig', ['controller_name' => 'PhotoArticleController',]);
    }


    /**
     * @Route("/photoarticle/getall/{id}" , methods={"GET"} , name="gettallphotoarticle")
     */
    public function getallphotoarticle($id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(PhotoArticle::class)->findBy(['article'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'photoarticle']);
        return $this->json($data, 200);
    }


    /**
     * @Route("/photoarticle/get/{id}/{size}" , methods={"GET"} , name="gettphotobyid")
     */
    public function getphotobyid($id,$size="thumb.jpg"){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(PhotoArticle::class)->findBy(['id'=>$id]);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'photoarticle']);
        if ($size=="thumb.jpg"){
            $image = base64_decode(str_replace("data:image/jpeg;base64", "", $data["0"]["data"]));
            $im = new Imagick();
            $im->readImageBlob($image);
            $im->thumbnailImage(300,182,true);
            header("Content-Type: image/png");
            echo($im);
        }
        return $this->json($data, 200);
    }


    /**
     * @Route("/photoarticle/add", name="add-photoarticle", methods={"POST"})
     */
    public function add(Request $request)
    {
        $photoarticle=new PhotoArticle();
        $data= $request->get('data');
        $idarticle= $request->get('article_id');
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findOneBy(['id'=>$idarticle]);
        if(!$article){
            return $this->json('error',400);
        }
        $photoarticle->setData(str_replace(' ', '+', $data));
        $photoarticle->setArticle($article);
        $this->entityManager->persist($photoarticle);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photoarticle/update/{id}", name="update-photoarticle", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $photoarticle = $this->getDoctrine()->getManager()->getRepository(PhotoArticle::class)->findOneBy(['id'=>$id]);
        $data= $request->get('data');
        $idarticle= $request->get('article_id');
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findOneBy(['id'=>$idarticle]);
        if(!$article){
            return $this->json('error',400);
        }
        $photoarticle->setData(str_replace(' ', '+', $data));
        $photoarticle->setArticle($article);
        $this->entityManager->persist($photoarticle);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/photoarticle/delete/{id}", name="delete_photoarticlee", methods={"POST"})
     */
    public function delete($id){
        $photoarticle = $this->getDoctrine()->getManager()->getRepository(PhotoArticle::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($photoarticle);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }






















}
