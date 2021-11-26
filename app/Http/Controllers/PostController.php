<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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
        $posts = Post::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
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
        //
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
