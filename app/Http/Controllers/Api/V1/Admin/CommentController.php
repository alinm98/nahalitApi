<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\V1\CommentCollection;
use App\Http\Resources\v1\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = new Comment();
    }

    /**
     * Display a listing of the resource.
     *
     * @return CommentCollection
     */
    public function index():CommentCollection
    {

        /* Get All Comments */
        $comments = $this->model->all();
        /* Get All Comments */

        return new CommentCollection($comments);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $comment = $this->model->where('id', $id)->first();

        /* Check Comment Exists */
        if(!$comment){
            return response([
                'result' => false,
                'message' => 'کامنت پیدا نشد'
            ], 404);
        }
        /* Check Comment Exists */

        /* Delete Comment */
        $res = $comment->delete();
        /* Delete Comment */

        /* Check Comment Deleted */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انجام عملیات'
            ], 400);
        }
        /* Check Comment Deleted */

        /* Return Response */
        return response([
            'result' => true,
            'message' => 'با موفقیت حذف شد'
        ], 200);
        /* Return Response */

    }

    /**
     * Confirm Comment.
     *
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function confirmComment($id)
    {
        $comment = $this->model->where('id', $id)->first();

        /* Check Exists Comment */
        if(!$comment){
            return response([
                'result' => false,
                'message' => 'کامنت پیدا نشد'
            ], 404);
        }
        /* Check Exists Comment */

        /* Confirm Comment */
        $comment->update([
            'status' => true,
        ]);
        /* Confirm Comment */

        /* Return Response */
        return response([
            'result' => true,
            'message' => 'نظر با موفقیت تایید شد'
        ], 200);
        /* Return Response */

    }
}
