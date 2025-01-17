<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SinglePostResource;


class PostController extends Controller
{
    public function addNewPost(Request $request){
        $validated = Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(),403);
        }

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $post->save();

             //return
             return response()->json([
                'message' => 'Post added successfully',
            ],200);

        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()],403);
        }
    }

    //edit a post
    public function editPost(Request $request){
        $validated = Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(),403);
        }

        try {
            $post_data = Post::find($request->post_id);

           $updatePost = $post_data->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
             //return
             return response()->json([
                'message' => 'Post updated successfully',
                'updated_post' => $updatePost,
            ],200);

        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()],403);
        }
    }

    //edit a post approach 2
    public function editPost2(Request $request,$post_id){
        $validated = Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',

        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(),403);
        }

        try {
            $post_data = Post::find($post_id);

           $updatePost = $post_data->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
             //return
             return response()->json([
                'message' => 'Post updated successfully ok',
                'updated_post' => $updatePost,
            ],200);

        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()],403);
        }
    }

    //retrieve all posts
    public function getAllPosts(){
        try {
            $posts = Post::all();
            return response()->json([
                'posts' => $posts
            ],200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],403);
        }
    }


    //fetch single post
    public function getPost($post_id){
        try {
         $post = Post::where('id',$post_id)->first();
    //$post = Post::with('user','comment','likes')->where('id',$post_id)->first();
            return response()->json([
                'post' => $post

            ],200);
        } catch (\Exception $th) {
                        return response()->json(['error' => $th->getMessage()],403);
        }
    }

    public function deletePost(Request $request, $post_id){
        try {
            $post = Post::find($post_id);
            $post->delete();
            return response()->json([
                'message' => 'post deleted successfully ok'
            ],200);
        } catch (\Exception $th) {
                return response()->json(['error' => $th->getMessage()],403);

            }
        }

    }
