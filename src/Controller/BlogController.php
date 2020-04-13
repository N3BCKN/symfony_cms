<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
* @Route("/blog")
*/
class BlogController extends AbstractController
{   

    /**
     * @Route("/", name="blog_index", methods={"GET"})
     */
    public function index()
    {
        return $this->json($this->getDoctrine()->getRepository(BlogPost::class)->findAll());
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d"}, methods={"GET"})
     */
    public function show(BlogPost $post){
        return $this->json($post); 
   }

    /**
     * @Route("/post/slug/{slug}", name="blog_by_slug", methods={"GET"})
     */
    public function showBySlug(BlogPost $post){
        return $this->json($post); 
    }

    /**
     * @Route("/add", name="add_new_post", methods={"POST"})
     */
    public function add(Request $request){
        
        /**@var Serializer $serializer */
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();
        
        return $this->json($blogPost);
    }   

    /**
     * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
     */
    public function deletePost(BlogPost $post){
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
    
    

}
