<?php

namespace App\Controller;

use App\Entity\Image;
use ApiPlatform\Core\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Form\ImageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UploadImageAction{

    private $formFactory;
    private $entityManager;
    private $validator;

    public function __construct(FormFactoryInterface $formFactory, 
    EntityManagerInterface $entityManager,
    ValidatorInterface $validator)
    {
        $this->formFactory   = $formFactory;
        $this->entityManager = $entityManager;
        $this->validator     = $validator;
    }

    // save file if form is valid
    public function __invoke(Request $request)
    {
        $image = new Image();

        $form = $this->formFactory->create(ImageForm::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($image);
            $this->entityManager->flush();

            $image->setFile(null);

            return $image;
        }
        throw new ValidationException($this->validator->validate($image));


        //throw error if something went wrong
    }    

    
    
}