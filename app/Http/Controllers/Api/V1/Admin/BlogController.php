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

            $path = $file->store('public/images/blogs');

            $data['image'] = $path;
        }
        /* Store Image */

        /* Validate Is_Active Field */
        if($request->has('is_active')){
            $data['is_active'] = true;
        }else{
            $data['is_active'] = false;
        }
        /* Validate Is_Active Field */

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, Blog $blog): \Illuminate\Http\Response
    {

        $newData = $request->all();

        /* Store Image */
        if($request->hasFile('image')){

            /* Delete Old Image */
            if(Storage::exists('public/Blogs/Images/' . $blog->image)){
                Storage::delete('public/Blogs/Images/' . $blog->image);
            }
            /* Delete Old Image */

            /* Store New Image */
            $file = $request->file('image');

            $path = $file->store('public/Blogs/Images/');

            $newData['image'] = $path;
            /* Store New Image */

        }
        /* Store Image */

        /* Validate Is_Active Field */
        if($request->has('is_active')){
            $newData['is_acitve'] = true;
        }else{
            $newData['is_acitve'] = false;
        }
        /* Validate Is_Active Field */

        /* Update Blog */
        $res = $blog->update($newData);
        /* Update Blog */

        /* Check Blog Updated */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انحام عملیات'
            ], 500);
        }
        /* Check Blog Updated */

        return response([
            'result' => true,
            'message' => 'با موفقیت اپدیت شد'
        ], 200);

    }

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
}
