<?php namespace App\Http\Controllers;

use App\Errors\APIError;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Errors\PostError;

class AdminPostController extends Controller
{
    public function all(Request $request)
    {
        $query = Post::query();
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        return response()->json($query->get()->toArray());
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Post::createValidator($input);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $post = new Post($input);
        $post->status = Post::STATUS_ENUM['DRAFT'];
        $post->save();
        if (!$post) {
            return new APIError(PostError::POST_CREATION_FAILED);
        }
        return response()->json($post);
    }

    public function get($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return new APIError(PostError::POST_NOT_FOUND);
        }
        if ($post->status === Post::STATUS_ENUM['DELETED']) {
            return new APIError(PostError::POST_ALREADY_DELETED);
        }
        return response()->json($post);
    }

    public function remove($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return new APIError(PostError::POST_NOT_FOUND);
        }
        if ($post->status === Post::STATUS_ENUM['DELETED']) {
            return new APIError(PostError::POST_ALREADY_DELETED);
        }
        $post->save(['status' => Post::STATUS_ENUM['DELETED']]);
        return response('', 204);
    }

    public function update(Request $request, $postId)
    {
        $input = $request->all();
        $validator = Post::updateValidator($input);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $post = Post::find($postId);
        if (!$post) {
            return new APIError(PostError::POST_NOT_FOUND);
        }

        $post->fill($input);
        $post->save();
        return response()->json($post);
    }
}