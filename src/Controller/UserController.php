<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/getall" , methods={"GET"} , name="gettalluser")
     */
    public function getalluser(){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' =>
            'user']);
        return $this->json($data, 200);
    }

    /**
     * @Route("/user/add", name="add-user", methods={"POST"})
     */
    public function add(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $username= $request->get('username');
        $password = $encoder->encodePassword($user, $request->get("password"));
        $user->setEmail($username);
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRoles(["Admin"]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $message = [
            'satus' => 201,
            'message' => 'success'
        ];
        return $this->json($message, 201);
    }

    /**
     * @Route("/user/update/{id}", name="update-user", methods={"Post"})
     */
    public function update(Request $request, $id, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$id]);
        $username= $request->get('username');
        $mdp = $encoder->encodePassword($user, $request->get("password"));

        $user->setUsername($username);
        $user->setPassword($mdp);
        $user->setEmail($username);
        $user->setRoles(["Admin"]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $this->json('success',200);
    }

    /**
     * @Route("/user/delete/{id}", name="delete_user", methods={"POST"})
     */
    public function delete($id){
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id'=>$id]);
        $this->entityManager ->remove($user);
        $this->entityManager ->flush();
        return $this->json('success remove',200);
    }








}
