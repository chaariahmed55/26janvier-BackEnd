<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Presse;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;




class ArticleController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/article/getall" , methods={"GET"} , name="gettallarticle")
     */
    public function getallarticle(){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findAll();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($article, null, ['groups' =>
            'article']);
        $newData=[];
        foreach ($data as $row ){
            $photo=$row["photoArticles"];
            if (count($photo) >0 ){
                $row["photoArticles"]= $photo[0];
            }
            $newData[]= $row;
        }
        return $this->json($newData, 200);
    }

    /**
     * @Route("/article/add", name="add-article", methods={"POST"})
     */
    public function add(Request $request)
    {
        $article = new Article();
        $title= $request->get('title');
        $date= $request->get('date');
        $description= $request->get('description');
        $source=$request->get('source');
        $descriptionar= $request->get('descriptionar');
        $titlear= $request->get('titlear');
        $idautor= $request->get('autor_id');
        $autor = $this->getDoctrine()->getManager()->getRepository(Presse::class)->findOneBy(['id'=>$idautor]);
        if(!$autor){
            return $this->json('error presse',400);
        }
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error admin',400);
        }
        $article->setTitle($title);
        $article->setDescription($description);
        $article->setDate($date);
        $article->setSource($source);
        $article->setTitlear($titlear);
        $article->setDescriptionar($descriptionar);
        $article->setAutor($autor);
        $article->setAdmin($admin);
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($article->getId(), 201);
    }

    /**
     * @Route("/article/update/{id}", name="update-article", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findOneBy(['id'=>$id]);
        $title= $request->get('title');
        $date= $request->get('date');
        $description= $request->get('description');
        $source=$request->get('source');
        $descriptionar= $request->get('descriptionar');
        $titlear= $request->get('titlear');
        $idautor= $request->get('autor_id');
        $autor = $this->getDoctrine()->getManager()->getRepository(Presse::class)->findOneBy(['id'=>$idautor]);
        if(!$autor){
            return $this->json('error presse',400);
        }
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error admin',400);
        }
        $article->setTitle($title);
        $article->setDescription($description);
        $article->setDate($date);
        $article->setSource($source);
        $article->setTitlear($titlear);
        $article->setDescriptionar($descriptionar);
        $article->setAutor($autor);
        $article->setAdmin($admin);
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/article/delete/{id}", name="delete-article", methods={"Post"})
     */
    public function delete($id){
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findOneBy(['id'=>$id]);
        $this->entityManager->remove($article);
        $this->entityManager->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/article/getallbytypedate" , name="get-all-article-by-typedepresse-page" , methods={"POST"})
     */
    public function getdifferenttypepage2(Request $request)
    {
        $datedebut = $request->get('datedebut');
        $datefin = $request->get('datefin');
        $typeoftrie=$request->get('typeoftrie');
        $nbpage = $request->get('nbpage');
        $page = $request->get('page');
        $type = $request->get('type');
        $newData=[];
        if ($type==""){
            $query=" select a.id from article a  where  a.date BETWEEN '".$datedebut."' and '".$datefin."' ORDER BY a.date ".$typeoftrie." LIMIT ".$nbpage." OFFSET ".$page*$nbpage.";";
        }else{
            $query=" select a.id from presse p  join article a  on p.id = a.autor_id where p.type= '".$type."' AND a.date BETWEEN '".$datedebut."' and '".$datefin."' ORDER BY a.date ".$typeoftrie." LIMIT ".$nbpage." OFFSET ".$page*$nbpage.";";
        }
        $req = $this->entityManager->getConnection()->prepare($query);
        $req->execute();
        $idarticles = $req->fetchAllAssociative();
        foreach ($idarticles as $idar) {
            $query1 = " select a.*,pa.id as photo_id from article a RIGHT join photo_article pa on pa.article_id =a.id WHERE a.id=".$idar['id']." limit 1";
            $req1 = $this->entityManager->getConnection()->prepare($query1);
            $req1->execute();
            $articles = $req1->fetchAllAssociative();
            $newData[]=$articles;
        }
        return $this->json($newData, 200);
    }


//        /**
//     * @Route("/article/getallbydate" , name="get-all-article-by-date",methods={"POST"})
//     */
//    public function getbydate(Request $request)
//    {
//        $datedebut = $request->get('datedebut');
//        $datefin = $request->get('datefin');
//        $typeoftrie=$request->get('typeoftrie');
//        $nbpage = $request->get('nbpage');
//        $page = $request->get('page');
//        $newData=[];
//        $query=" SELECT a.id from article a where a.date BETWEEN '".$datedebut."' and '".$datefin."' ORDER BY a.date ".$typeoftrie."
//                       LIMIT ".$nbpage." OFFSET ".$page.$nbpage;
//        $req = $this->entityManager->getConnection()->prepare($query);
//        $req->execute();
//        $idarticles = $req->fetchAllAssociative();
//        foreach ($idarticles as $idar) {
//            $query1 = " select pa.*,pa.article_id from Article a RIGHT join Photo_Article pa on pa.article_id =a.id WHERE a.id=".$idar['id']." limit 1";
//            $req1 = $this->entityManager->getConnection()->prepare($query1);
//            $req1->execute();
//            $articles = $req1->fetchAllAssociative();
//            $newData[]=$articles;
//        }
//        return $this->json($newData, 200);
//    }

}
