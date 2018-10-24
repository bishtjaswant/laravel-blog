<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Notifications\newAuthorPost;
use App\Post;
use App\Tag;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "categories" => "required",
            "tags" => "required",
            "image" => "required"
        ]);


//        get the post photo
        $image = $request->file('image');

        //    create  a slug
        $slug = str_slug($request->title, '-');

//        ensure the dir whare our post photo will be uploaded
        if ( isset($image) ){

            $currentDate = Carbon::now()->toDateString();

            $fileName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();


//            check the dir
            if (!Storage::disk('public')->exists('posts')) {
//                than make new dir for post
                Storage::disk('public')->makeDirectory('posts');
            }



//            if dir exist
            if (Storage::disk('public')->exists('posts')) {
//
//                now manipulatting the pic
                $postPic = Image::make($image)->resize(1600,666)->save();

                Storage::disk('public')->put('posts/'.$fileName, $postPic);

//                finally save into db
                $post = new Post();
                $post->user_id = Auth::id();
                $post->title = $request->title;
                $post->slug = $slug;
                $post->body = $request->body;
                $post->image = $fileName;

//                if user  want publish the post
                if ($request->status ) {
                    $post->status = true;
                    $post->is_approved= false;
                } else  {
                    $post->status = false;
                    $post->is_approved = false;
                }

                $post->save();

                $post->tags()->attach($request->tags);
                $post->categories()->attach($request->categories);

//                also send the notification to admin
                $admin = User::where('role_id', '1')->get();  // get the admin
                Notification::send($admin, new newAuthorPost($post) );



                Toastr::success('your post created', 'Success');
                return redirect()->route('author.post.index');


            }


        }
        else {
            $fileName = 'default.png';
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        if ($post->user_id != Auth::id() ) {
            Toastr::error('You are not authorized to access this post', 'Error');
            return redirect()->back();
        }
        return view('author.post.show', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if ($post->user_id != Auth::id() ) {
            Toastr::error('You are not authorized to edit this post', 'Error');
            return redirect()->back();
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit', compact('categories','post', 'tags'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        if ($post->user_id != Auth::id() ) {
            Toastr::error('You are not authorized to update this post', 'Error');
            return redirect()->back();
        }


        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "categories" => "required",
            "tags" => "required",
            "image" => "image"
        ]);


//        get the post photo
        $image = $request->file('image');

        //    create  a slug
        $slug = str_slug($request->title, '-');

//        ensure the dir whare our post photo will be uploaded
        if ( isset($image) ){

            $currentDate = Carbon::now()->toDateString();

            $fileName = $slug.'-'.$currentDate.'-'.uniqid().'.' . $image->getClientOriginalExtension();


//            check the dir
            if (!Storage::disk('public')->exists('posts')) {
//                than make new dir for post
                Storage::disk('public')->makeDirectory('posts');
            }

//            deleting old posst pic
            if (Storage::disk('public')->exists('posts/'.$post->image)){
                Storage::disk('public')->delete('posts/'.$post->image);
            }


//            if dir exist
            if (Storage::disk('public')->exists('posts')) {
//
//                now manipulatting the pic
                $postPic = Image::make($image)->resize(1600,666)->save();

                Storage::disk('public')->put('posts/'.$fileName, $postPic);


            }


        }
        else {
            $fileName = $post->image; // in case if user does not select any photo
        }


//    finally save updated into db
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        $post->image = $fileName;

//                if user  want publish the post
        if ($request->status ) {
            $post->status = true;
            $post->is_approved = false;
        } else  {
            $post->status = false;
        }

        $post->save();

        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);


        Toastr::success('POST UPDATED', 'Success');
        return redirect()->route('author.post.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->user_id != Auth::id() ) {
            Toastr::error('You are not authorized to remove this post', 'Error');
            return redirect()->back();
        }

        if (Storage::disk('public')->exists('posts/'.$post->image)) {
            Storage::disk('public')->delete('posts/'.$post->image);
        }



//        finally delete the all record;

        $post->categories()->detach();
        $post->tags()->detach();
        $post->forceDelete();
        return redirect()->back();




    }








}
