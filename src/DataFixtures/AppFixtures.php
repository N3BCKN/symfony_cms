<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var Faker\Factory
     */
    private $faker;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
      $this->passwordEncoder = $passwordEncoder;   
      $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setUsername("j.Doe");
        $user->setEmail("john.doe@gmail.com");
        $user->setName("John Doe");
        $user->setRoles([User::ROLE_ADMIN]);
        $user->setEnabled(true);
        $user->setPassword($this->passwordEncoder->encodePassword(
          $user,
          'secret123#@!'
        ));

        $this->addReference('user_admin',$user);

        $manager->persist($user);

        $user1 = new User();
        $user1->setUsername("j.Kow");
        $user1->setEmail("jan.kowalski@gmail.com");
        $user1->setName("Jan Kowalski");
        $user1->setEnabled(true);
        $user1->setRoles([User::ROLE_WRITER]);
        $user1->setPassword($this->passwordEncoder->encodePassword(
          $user1,
          'secret123#@!'
        ));

        $this->addReference('user_writer',$user1);

        $manager->persist($user1);



        $manager->flush();
    }

    public function loadBlogPosts(ObjectManager $manager){

        $user = $this->getReference('user_admin');

        for($i = 0; $i < 50; $i++){

            $blogPost = new BlogPost();
            $randomID = rand(1, 500);
            $blogPost-> setTitle($this->faker->realText(40));
            $blogPost-> setContent($this->faker->realText(350));
            $blogPost->setAuthor($user);
            $blogPost->setPublished($this->faker->dateTimeThisYear);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post_$i", $blogPost);
            
            $manager->persist($blogPost);
            }
    
            $manager->flush();
    }

    public function loadComments(ObjectManager $manager){
            
            for($i = 0; $i < 50; $i++){
                for($j = 0; $j < rand(1,10); $j++){
                    $comment = new Comment();
                    $comment -> setContent($this->faker->realText(60));
                    $comment -> setPublished($this->faker->dateTimeThisYear);
                    $comment -> setAuthor($this->getReference('user_admin'));
                    $comment -> setBlogPost($this->getReference("blog_post_$i"));
                    

                    $manager->persist($comment);

                }
            }

            $manager->flush();  
    }
}
