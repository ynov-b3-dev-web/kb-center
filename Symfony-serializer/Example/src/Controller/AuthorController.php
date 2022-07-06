<?php

namespace App\Controller;

use App\Entity\Author;
use AppBundle\Entity\Article;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author/{id}", name="author_show")
     */
    public function show(ManagerRegistry $managerRegistry, int $id)
    {
        $article = $managerRegistry->getRepository(Article::class)->find($id);

        $author = new Author();
        $author->setFullname('Sarah Khalil');
        $author->setBiography('Ma super biographie.');
        $author->getArticles()->add($article);


        $data =  $this->get('serializer')->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
