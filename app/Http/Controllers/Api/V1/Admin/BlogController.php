<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\V1\BlogCollection;
use App\Http\Resources\V1\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    private Blog $model;

    public function __construct()
    {
        $this->model = new Blog();
        //$this->middleware(checkPermissions::class.":view-blog")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-blog")->only(['store']);
        $this->middleware(checkPermissions::class.":update-blog")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-blog")->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response|BlogCollection
    {

        /* Get All Blogs */
        $blogs = $this->model->all();
        /* Get All Blogs */

        return new BlogCollection($blogs);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request): \Illuminate\Http\Response|BlogResource
    {

        $data = $request->all();

        /* Store Image */
        if($request->hasFile('image')){
            $file = $request->file('image');

            $path = $file->store('public/images/products');
            $image = str_replace('public', '/storage', $path);

            $data['image'] = url($image);
        }
        /* Store Image */


        /* Store Blog */
        $blog = $this->model->create($data);
        /* Store Blog */

        return new BlogResource($blog);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog): \Illuminate\Http\Response|BlogResource
    {

        return new BlogResource($blog);

    }


//    public function update(Request $request, Blog $blog)
//    {
//
//
//        $newData = $request->all();
//
//        /* Store Image */
//        if($request->hasFile('image')){
//
//            /* Delete Old Image */
//            if(Storage::exists('public/images/products' . $blog->image)){
//                Storage::delete('public/images/products' . $blog->image);
//            }
//            /* Delete Old Image */
//
//            /* Store New Image */
//            $file = $request->file('image');
//
//            $path = $file->store('public/images/products');
//            $image = str_replace('public', '/storage', $path);
//
//            $newData['image'] = url($image);
//            /* Store New Image */
//
//        }
//        /* Store Image */
//
//
//
//        /* Update Blog */
//        $data = $blog->update([
//            'title' => $newData['title'],
//            'image' => $newData['image'],
//            'body' => $newData['body'],
//            'user_id' => $newData['user_id'],
//            'is_active' => $newData['is_active'],
//        ]);
//        /* Update Blog */
//
//
//        return response([
//            'result' => true,
//            'message' => 'با موفقیت اپدیت شد'
//        ], 200);
//
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog): \Illuminate\Http\Response
    {

        /* Delete Blog */
        $res = $blog->delete();
        /* Delete Blog */

        /* Check Blog Deleted */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انجام عملیات'
            ], 500);
        }
        /* Check Blog Deleted */

        return response([
            'result' => true,
            'message' => 'با موفقیت حذف شد'
        ], 200);

    }

    public function search($value): \Illuminate\Database\Eloquent\Collection|array
    {
        $blogs = new Blog();
        return $blogs->search($value);
    }



    public function update(UpdateBlogRequest $request, Blog $blog): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $newData = $request->all();

        /* Store Image */
        if($request->hasFile('image')){

            /* Delete Old Image */
            if(Storage::exists('public/images/products' . $blog->image)){
                Storage::delete('public/images/products' . $blog->image);
            }
            /* Delete Old Image */

            /* Store New Image */
            $file = $request->file('image');

            $path = $file->store('public/images/products');
            $image = str_replace('public', '/storage', $path);

            $newData['image'] = url($image);
            /* Store New Image */

        }
        /* Store Image */



        /* Update Blog */
        $data = $blog->update([
            'title' => $newData['title'],
            'image' => $newData['image'],
            'body' => $newData['body'],
            'user_id' => $newData['user_id'],
            'is_active' => $newData['is_active'],
        ]);
        /* Update Blog */


        return response([
            'result' => true,
            'message' => 'با موفقیت اپدیت شد'
        ], 200);
    }
}
