<?php

namespace App\Services\Admins;

use App\Models\Admins\Post;
use App\Models\Admins\PostTag;
use App\Models\Admins\PostCategory;
use App\Traits\HelperTrait;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostService
{
    use HelperTrait;

    /**
     * @param Request $request
     * @return false|LengthAwarePaginator
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input("per_page") ?: config("constants.per_page");
            $search = $request->input("q");
            $query = Post::with(['author','category']);

            if ($request->has("q") && strlen($search) > 0) {
                $query->where("title", "LIKE", "%" . $search . "%");
            }
            if($request->has('start') && $request->has('end')){
                $start = Carbon::parse((int)$request->start)
                    ->timezone('Asia/Ho_Chi_Minh')->startOfDay();
                $end = Carbon::parse((int)$request->end)
                    ->timezone('Asia/Ho_Chi_Minh')->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            }

            return $query->orderBy('created_at', 'DESC')->paginate($perPage);
        } catch (Exception $e) {
            Log::error("Error list post", [
                "method" => __METHOD__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * @param $id
     * @return false|Builder|Builder[]|Collection|Model|null
     */
    public function show($id)
    {
        try {
            return Post::with(['tags', 'category'])->find($id);
        } catch (Exception $e) {
            Log::error('Error get post detail', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function store(Request $request)
    {
        try {
            $post = new Post();
            $post->title = $request->input('title');
            $slug = $request->input('slug') ? $request->input("slug") : $request->input("title");
            $post->slug = createSlug(Post::class, $slug, null);
            $post->short_content = $request->input('short_content');
            $post->content = $request->input('content');
            $post->created_by = Auth::id();
            $post->post_category_id = $request->input('post_category_id') ? $request->input("post_category_id") : null;
            $post->status = (int)$request->input("status");

            if ($request->hasFile('banner')) {
                $fileName = $request->file('banner')->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('upload/images/posts', $request->file('banner'), $fileName);
                $post->banner_path = $path;
            }

            $post->save();

            if ($request->has("post_tag_ids")) {
                $post->tags()->attach($request->input("post_tag_ids", []));
            }

            return true;
        } catch (Exception $e) {
            Log::error('Error store post', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return false;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function update(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            $post->title = $request->input('title');
            $slug = $request->input('slug') ? $request->input("slug") : $request->input("title");
            $post->slug = createSlug(Post::class, $slug, $id);
            $post->short_content = $request->input('short_content');
            $post->content = $request->input('content');
            $post->post_category_id = $request->input('post_category_id') ? $request->input("post_category_id") : null;
            $post->status = (int)$request->input("status");
            if ($request->hasFile('banner')) {
                $fileName = $request->file('banner')->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('upload/images/posts', $request->file('banner'), $fileName);
                $post->banner_path = $path;
            }
            $post->save();

            if ($request->has("post_tag_ids")) {
                $post->tags()->attach($request->input("post_tag_ids", []));
            }
            return true;
        } catch (Exception $e) {
            Log::error('Error update post', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return false;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            $post->status = (int)$request->input("status");
            $post->save();
            return true;
        } catch (Exception $e) {
            Log::error('Error update is show web post', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);
            info($id);
            Storage::disk('public')->delete($post->banner_path);
            $post->tags()->detach($post->post_tag_ids);
            $post->delete();
            return true;
        } catch (Exception $e) {
            Log::error("Error delete post", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
                "id" => $id
            ]);

            return false;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function updateBanner(Request $request, $id)
    {
        try {
            $post = Post::find($id);

            if ($request->hasFile('banner')) {
                Storage::disk('public')->delete($post->banner_path);
                $fileName = $request->file('banner')->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('upload/images/posts', $request->file('banner'), $fileName);

                $post->banner_path = $path;
            }
            $post->banner_alt = $request->input('banner_alt');
            $post->save();

            return true;
        } catch (Exception $e) {
            Log::error('Error update banner post', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return false;
        }
    }

    public function storePostTag(Request $request, $id)
    {
        try {
            $tag = new PostTag();
            $tag->name = $request->name;
            $tag->save();

            $post = Post::find($id);
            $post->tags()->attach($tag->_id);

            return true;
        } catch (Exception $e) {
            Log::error('Error store post tag', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return false;
        }
    }

    /**
     * @return false|LengthAwarePaginator
     */
    public function getAllPostCategory()
    {
        try {
            return PostCategory::orderBy("created_at",'DESC')->get();
        } catch (Exception $e) {
            Log::error("Error list all post category", [
                "method" => __METHOD__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * @return false|LengthAwarePaginator
     */
    public function getAllTags()
    {
        try {
            return PostTag::orderBy("created_at",'DESC')->get();
        } catch (Exception $e) {
            Log::error("Error list all post category", [
                "method" => __METHOD__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }
}
