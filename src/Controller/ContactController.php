<?php

namespace App\Controller;

use App\Entity\Contact;
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

class ContactController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }



    /**
     * @Route("/contact/getall/{page}" , methods={"GET"} , name="gettallcontact")
     */
    public function getallcontact(Request $request,$page){
//        $page=$request->get('page');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact=$this->entityManager
        ->createQuery('SELECT c FROM App\Entity\Contact c WHERE c.moved = false ')
        ->setMaxResults(10)
        ->setFirstResult($page*10)
        ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($contact, null, ['groups' =>
            'contact']);
        return $this->json($data, 200);
    }
    

    /**
     * @Route("/contact/maxpage", methods={"GET"} , name="getmaxpage")
     */
    public function getmaxpage()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact=$this->entityManager
        ->createQuery('SELECT count(c) FROM App\Entity\Contact c WHERE c.moved = false ')
        ->getResult();
        return $this->json($contact, 200);
    }

    /**
     * @Route("/contact/numnonvue", methods={"GET"} , name="getnumnonvue")
     */
    public function getnumnonvue()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact=$this->entityManager
        ->createQuery('SELECT count(c) FROM App\Entity\Contact c WHERE c.vue = false ')
        ->getResult();
        return $this->json($contact, 200);
    }

    /**
     * @Route("/contact/maxpagemoved", methods={"GET"} , name="getmaxpagemoved")
     */
    public function getmaxpagemoved()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact=$this->entityManager
        ->createQuery('SELECT count(c) FROM App\Entity\Contact c WHERE c.moved = true ')
        ->getResult();
        return $this->json($contact, 200);
    }

/**
     * @Route("/contact/getallmoved/{page}" , methods={"GET"} , name="gettallmovedcontact")
     */
    public function getallmovedcontact($page){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact=$this->entityManager
        ->createQuery('SELECT c FROM App\Entity\Contact c WHERE c.moved = true ')
        ->setMaxResults(10)
        ->setFirstResult($page*10)
        ->getResult();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($contact, null, ['groups' =>
            'contact']);
        return $this->json($data, 200);
    }


    /**
     * @Route("/contact/add", name="add-contact", methods={"POST"})
     */
    public function add(Request $request)
    {
        $contact = new Contact();
        $email=$request->get('email');
        $name=$request->get('name');
        $subject=$request->get('subject');
        $tel=$request->get('tel');
        $message=$request->get('message');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $contact->setVue(false);
        $contact->setMoved(false);
        $contact->setEmail($email);
        $contact->setName($name);
        $contact->setTel($tel);
        $contact->setMessage($message);
        $contact->setSubject($subject);
        $contact->setAdmin($admin);
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }



    /**
     * @Route("/contact/update/{id}", name="update-contact", methods={"Post"})
     */
    public function update(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(['id'=>$id]);
        $vue=$request->get('vue');
        $moved=$request->get('moved');
        $email=$request->get('email');
        $name=$request->get('name');
        $subject=$request->get('subject');
        $tel=$request->get('tel');
        $message=$request->get('message');
        $idadmin= $request->get('admin_id');
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$idadmin]);
        if(!$admin){
            return $this->json('error',400);
        }
        $contact->setVue($vue);
        $contact->setMoved($moved);
        $contact->setEmail($email);
        $contact->setName($name);
        $contact->setTel($tel);
        $contact->setMessage($message);
        $contact->setSubject($subject);
        $contact->setAdmin($admin);
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
        return $this->json('success',200);
    }


    /**
     * @Route("/contact/vued/{id}", name="vued-contact", methods={"Post"})
     */
    public function vued(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(['id'=>$id]);
        $contact->setVue(true);
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

/**
     * @Route("/contact/moved/{id}", name="moved-contact", methods={"Post"})
     */
    public function moved(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(['id'=>$id]);
        $contact->setMoved(true);
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
        return $this->json('success',200);
    }






    /**
     * @Route("/contact/delete/{id}", name="delete_article", methods={"POST"})
     */
    public function delete($id){
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($contact);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }


    /**
     * @Route("/contact/getbyemail/{email}" , methods={"GET"} ,name="getbyemail")
     */
    public function getbyname($email,Request $request)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findBy(
            ['email' => $email]
        );
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($contact, null, ['groups' =>
            'contact']);
        return $this->json($data, 200);
    }












}
