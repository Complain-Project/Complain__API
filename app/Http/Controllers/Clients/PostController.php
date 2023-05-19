<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Admins\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->with('author')
            ->where('status', Post::STATUS['ACTIVE']);
        $q = $request->q;
        $date = $request->date;
        if ($q && strlen($q) > 0) {
            $query->where('title', 'LIKE', '%' . $q . '%');
        }
        if ($date && strlen($date) > 0) {
            $start = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }
        $posts = $query->orderByDesc('created_at')->paginate(10);
        return view('pages.posts', [
            'posts' => $posts,
            'q' => $q,
            'date' => $date
        ]);
    }

    public function show($slug)
    {
        $post = Post::query()->where('slug', $slug)->first();

        if (!$post) {
            return redirect()->route('posts')->with('error', 'Không tìm thấy bài viết.');
        }

        return view('pages.detail_post', [
            'post' => $post,
        ]);
    }
}
