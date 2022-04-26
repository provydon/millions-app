<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Like as ResourcesLike;
use App\Http\Resources\Post as ResourcesPost;
use App\Models\Like;
use App\Models\Post;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'like', 'unlike','likes']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResourcesPost::collection(Post::orderBy("created_at", "desc")->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = now("GMT+1")->format("YmdHi") . Str::random(10);
        $user = Auth::user();

        if ($request->image && !$request->file("image")) {
            if ($request->isBase64 == null || $request->file_type == null) {
                return Helper::apiRes("isBase64 and file_type fields are required for base64 image", [], false, 422);
            }
        }

        $post = new Post;
        $post->user_id = $user->id;
        $post->description = $request->description;
        $path = FileService::storeFile($request->image, 'images', false, (bool)$request->isBase64, $filename, $request->file_type);
        $post->image = $path;
        $post->save();

        return Helper::apiRes("Post Submitted", new ResourcesPost($post), true, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Helper::apiRes("Post", new ResourcesPost($post), true, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return Helper::apiRes("Post Deleted");
    }

    public function like(Request $request)
    {
        $user = Auth::user();
        $like = Like::where("user_id", $user->id)->where("post_id", $request->post_id)->first();
        if (!$like) {
            $like = new Like;
            $like->user_id = $user->id;
            $like->post_id = $request->post_id;
            $like->save();
        }
        return Helper::apiRes("Post Liked");
    }

    public function unLike(Request $request)
    {
        $user = Auth::user();
        $like = Like::where("user_id", $user->id)->where("post_id", $request->post_id)->first();
        if ($like) {
            $like->delete();
        }
        return Helper::apiRes("Post UnLiked");
    }

    public function likes(Post $post)
    {
        return Helper::apiRes("Post Likes", ResourcesLike::collection($post->likes));
    }
}
