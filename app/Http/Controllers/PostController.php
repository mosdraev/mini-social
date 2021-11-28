<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\PostRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    use HasImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::getPosts();

        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * Modifies post visibility to private or public
     *
     * @param Post $post
     * @param string $visibility public|private
     *
     * @return \Illuminate\Http\Response
     */
    public function updateVisibility(Post $post, $visibility)
    {
        $result = $post->update([
            'visibility' => $visibility
        ]);

        if ($result)
        {
            return redirect(route('post.index'))
                ->with('type', 'alert-success')
                ->with('message', "Post is now $visibility.");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Post\PostRequest  $PostRequest
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $image = $this->upload($request, 'post');

        if ($image && $image->wasRecentlyCreated)
        {
            $result = Post::createPost($request->validated(), $image);
        }
        else
        {
            $result = Post::createPost($request->validated());
        }

        if ($result)
        {
            return redirect(route('post.index'))
                ->with('type', 'alert-success')
                ->with('message', 'post is now published.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Post/View', [
            'post' => $post
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function storeComment(CommentRequest $request, Post $post)
    {
        $data = $request->validated();

        $comment = new Comment();
        $comment->makeComment($data, $post);

        return back()
                ->with('type', 'alert-success')
                ->with('message', 'post is now published.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function storeLike(Request $request, Post $post)
    {
        $like = new Like();
        $like->likeOrUnlike($request, $post);

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Profile\PostRequest  $PostRequest
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $PostRequest, Post $post)
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
        //
    }
}
