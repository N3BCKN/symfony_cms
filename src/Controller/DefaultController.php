<?php 
    namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController{

    /**
     * @Route("/", name="default_index")
     * @Method({"GET"})
     */
    public function index(){
        
        return new JsonResponse([
            'action' => 'index',
            'time'   => time()
        ]);
    }
}

?>