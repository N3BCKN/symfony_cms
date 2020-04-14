<?php 
    namespace App\Controller;

use App\Security\UserConfirmationService;
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
            'world'  => 'hello',
            'time'   => time()
        ]);
    }

    /**
     * @Route("/user-confirmation/{token}", name="confirm_index")
     * @Method({"GET"})
     */
    public function confirmUser(string $token, UserConfirmationService $userConfirmationService)
    {
        $userConfirmationService->confirmUser($token);

        return $this->redirectToRoute('default_index');
    }
}

?>