<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function postComment(Request $request){

        $validated = Validator::make($request->all(),[
            'post_id' => 'required|integer',
            'comment' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(),403);
        }

        try {
            $post = new Comment();
            $post->post_id = $request->post_id;
            $post->comment = $request->comment;
            $post->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $post->save();

             //return
             return response()->json([
                'message' => 'Comment added successfully ok',
            ],200);

        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()],403);
        }

    }
}
