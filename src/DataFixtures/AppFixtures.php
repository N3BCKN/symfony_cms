<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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
        $user->setPassword("secret123!@#");

        $this->addReference('user_admin',$user);

        $manager->persist($user);
        $manager->flush();
    }

    public function loadBlogPosts(ObjectManager $manager){

        $user = $this->getReference('user_admin');

        for($i = 0; $i < 20; $i++){

            $blogPost = new BlogPost();
            $randomID = rand(1, 500);
            $blogPost-> setTitle("Blog Post title number: ". $randomID );
            $blogPost-> setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut consequat semper viverra 
            nam libero justo laoreet. Odio ut sem nulla pharetra diam sit amet nisl suscipit. Ultricies 
            lacus sed turpis tincidunt id aliquet risus feugiat in. Interdum varius sit amet mattis 
            vulputate enim nulla aliquet porttitor. Turpis nunc eget lorem dolor sed viverra ipsum nunc 
            aliquet. Mattis vulputate enim nulla aliquet porttitor. Nec ullamcorper sit amet risus nullam 
            eget felis eget nunc. Molestie a iaculis at erat pellentesque adipiscing commodo elit. 
            Dignissim cras tincidunt lobortis feugiat vivamus at. Ullamcorper velit sed ullamcorper morbi. 
            Vulputate dignissim suspendisse in est ante in nibh mauris cursus. 
            Aenean et tortor at risus viverra adipiscing. Diam ut venenatis tellus in metus. 
            Aliquet bibendum enim facilisis gravida neque convallis. Nisl tincidunt eget nullam non nisi est 
            sit amet. Tristique senectus et netus et malesuada fames. Diam maecenas sed enim ut sem viverra.");
            $blogPost->setAuthor($user);
            $blogPost->setPublished(new DateTime('now'));
            $blogPost->setSlug("blog-post-title-number-".$randomID);
            
            $manager->persist($blogPost);
            }
    
            $manager->flush();
    }

    public function loadComments(ObjectManager $manager){

    }
}
