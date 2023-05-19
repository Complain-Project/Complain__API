<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Services\Admins\PostService;
use App\Services\Admins\PostTagService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ResponseTrait;

    private $postService;
    private $postTagService;

    /**
     * @param PostService $post
     * @param PostTagService $postTagService
     */
    public function __construct(PostService $post, PostTagService $postTagService)
    {
        $this->postService = $post;
        $this->postTagService = $postTagService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $posts = $this->postService->index($request);

        return $posts ? $this->responseSuccess($posts) : $this->responseError();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $post = $this->postService->show($id);

        return $post ? $this->responseSuccess($post) : $this->responseError();
    }

    /**
     * @return JsonResponse
     */
    public function getAllTag()
    {
        $tags = $this->postTagService->getAll();

        return $tags ? $this->responseSuccess($tags) : $this->responseError();
    }

    /**
     *  * @param Request $request
     * @return JsonResponse
     */
    public function storeTag(Request $request)
    {
        $tag = $this->postTagService->store($request);

        return $tag ? $this->responseSuccess($tag) : $this->responseError();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBanner(Request $request, $id)
    {
        $tags = $this->postService->updateBanner($request, $id);

        return $tags ? $this->responseSuccess($tags) : $this->responseError();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
        public function store(Request $request)
    {
        $post = $this->postService->store($request);

        return $post ? $this->responseSuccess() : $this->responseError();
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $post = $this->postService->update($request, $id);

        return $post ? $this->responseSuccess() : $this->responseError();
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $post = $this->postService->updateStatus($request, $id);

        return $post ? $this->responseSuccess() : $this->responseError();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $post = $this->postService->destroy($id);

        return $post ? $this->responseSuccess() : $this->responseError();
    }

    /**
     * @return JsonResponse
     */
    public function getAllPostCategory()
    {
        $postCategories = $this->postService->getAllPostCategory();

        return $postCategories ? $this->responseSuccess($postCategories) : $this->responseError();
    }

    /**
     * @return JsonResponse
     */
    public function getAllPostTags()
    {
        $postTags = $this->postService->getAllTags();

        return $postTags ? $this->responseSuccess($postTags) : $this->responseError();
    }
}
