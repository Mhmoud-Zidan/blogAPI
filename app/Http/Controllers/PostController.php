<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Post as PostResource;
use phpDocumentor\Reflection\Types\Resource_;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts), "all posts retrieved successfully");
    }

    public function userPosts($id)
    {
        $posts = Post::where('user_id', $id)->get();
        return $this->sendResponse(PostResource::collection($posts), "your posts retrieved successfully");
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError("validation error", $validator->errors());
        }
        $user = Auth::user();
        $input['user_id'] = $user->id;
        $post = Post::create($input);
        return $this->sendResponse($post, "post saved successfully");
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return $this->sendError("post not found ! ");
        }
        return $this->sendResponse(new PostResource($post), "post retrieved successfully");
    }

    public function update(Request $request, Post $post)
    {
        if($post->user_id !=Auth::id()){
            return $this->sendError("Not Your Post ! ");
        }
        $input = $request->all();


        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError("validation error", $validator->errors());
        }
        $post->update($input);
        return $this->sendResponse($post, "post updated successfully");
    }

    public function destroy(Post $post)
    {
        if($post->user_id !=Auth::id()){
            return $this->sendError("Not Your Post ! ");
        }
        $post->delete();
        return $this->sendResponse($post, "post deleted successfully");
    }
}
