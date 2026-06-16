<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{
    public const DATA = [
        [
            'id'          => "1",
            'title'       => 'Як почати роботу з Symfony 6.4',
            'content'     => 'Symfony — це PHP-фреймворк для створення вебзастосунків. У цій статті розглянемо встановлення через Composer, структуру проєкту та перший контролер.',
            'author'      => 'Олександр Коваленко',
            'publishedAt' => '2026-06-10'
        ],
        [
            'id'          => "2",
            'title'       => 'REST API: основні принципи',
            'content'     => 'REST API будується навколо HTTP-методів GET, POST, PATCH та DELETE. Кожен ресурс має власний URL, а дані передаються у форматі JSON.',
            'author'      => 'Марія Бондаренко',
            'publishedAt' => '2026-06-12'
        ],
        [
            'id'          => "3",
            'title'       => 'Робота з базою даних у Laravel',
            'content'     => 'Eloquent ORM спрощує взаємодію з базою даних. Міграції дозволяють керувати структурою таблиць, а моделі — зчитувати й записувати дані.',
            'author'      => 'Ігор Шевченко',
            'publishedAt' => '2026-06-14'
        ],
        [
            'id'          => "4",
            'title'       => 'Git для початківців: перші кроки',
            'content'     => 'Git — система контролю версій. Команди git init, git add, git commit і git push дозволяють зберігати історію змін та працювати в команді.',
            'author'      => 'Тетяна Мельник',
            'publishedAt' => '2026-06-15'
        ]
    ];
    #[Route('/posts', name: 'get_posts', methods: ['GET'])]
    public function getPosts(): Response
    {
        return new JsonResponse(self::DATA);
    }
    #[Route('/posts/{id}', name: 'get_post_by_id', methods: ['GET'])]
    public function getPostById(string $id): Response
    {
        foreach (self::DATA as $post) {
            if ($post['id'] === $id) {
                return new JsonResponse($post);
            }
        }
        return new JsonResponse();
    }
    #[Route('/posts', name: 'create_post', methods: ['POST'])]
    public function createPost(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $id = rand(5, 100);
        $data['id'] = $id;
        return new JsonResponse($data, Response::HTTP_CREATED);
    }
    #[Route('/posts/{id}', name: 'update_post', methods: ['PATCH'])]
    public function updatePost(string $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $oldPost = null;
        foreach (self::DATA as $post) {
            if ($post['id'] === $id) {
                $oldPost = $post;
            }
        }
        if (!$oldPost) {
            throw new NotFoundHttpException();
        }
        if (isset($data['title'])) {
            $oldPost['title'] = $data['title'];
        }
        if (isset($data['content'])) {
            $oldPost['content'] = $data['content'];
        }
        if (isset($data['author'])) {
            $oldPost['author'] = $data['author'];
        }
        if (isset($data['publishedAt'])) {
            $oldPost['publishedAt'] = $data['publishedAt'];
        }
        return new JsonResponse($oldPost);
    }
    #[Route('/posts/{id}', name: 'delete_post', methods: ['DELETE'])]
    public function deletePost(string $id): Response
    {
        foreach (self::DATA as $post) {
            if ($post['id'] === $id) {
                return new JsonResponse(null, Response::HTTP_NO_CONTENT);
            }
        }
        throw new NotFoundHttpException();
    }

}