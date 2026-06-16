<?php
namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function response;
class TestController extends Controller
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
    /**
     * @return Response
     */
    public function getPosts(): Response
    {
        return response()->json(self::DATA, Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param string $id
     * @return Response
     */
    public function getPostById(string $id): Response
    {
        foreach (self::DATA as $post) {
            if ($post['id'] === $id) {
                return response()->json($post, Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
            }
        }
        return response()->json([], Response::HTTP_OK);
    }
    /**
     * @param Request $request
     * @return Response
     */
    public function createPost(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $id = rand(5, 100);
        $data['id'] = $id;
        return response()->json($data, Response::HTTP_CREATED, [], JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param string $id
     * @param Request $request
     * @return Response
     */
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
        return response()->json($oldPost, Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param string $id
     * @return Response
     */
    public function deletePost(string $id): Response
    {
        foreach (self::DATA as $post) {
            if ($post['id'] === $id) {
                return response()->json(null, Response::HTTP_NO_CONTENT);
            }
        }
        throw new NotFoundHttpException();
    }
}
