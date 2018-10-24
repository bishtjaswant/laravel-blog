<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
      return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category.create');

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
             'categoryName' =>  'required',
             'categoryImage' => 'mimes:jpeg,bmp,png,jpg'
         ]);
//         name of file
         $image = $request->file('categoryImage');
//        slug
         $slug = str_slug($request->categoryName, '-');
         //         filename

        if (isset($image)) {
//            making uniqe namme for uploaded file
            $currentDate = Carbon::now()->toDateString();
//            gettong tghe new unique name for image
            $filename = $slug.'-'.$currentDate.'-'. uniqid().'.'.$image->getClientOriginalExtension();

//        now check tthe cateegory dir exist or nor

            if (!Storage::disk('public')->exists('category')) {
//                if diir not exist than make new dir within public that name is catetgoryImage;
                Storage::disk('public')->makeDirectory('category');

            }

//            resize image for category image
            $category = Image::make($image)->resize(1600,479)->save();

            Storage::disk('public')->put('category/'. $filename, $category );



//        now check tthe cateegory slider dir exist or nor

            if (!Storage::disk('public')->exists('category/slider')) {
//                if diir exist than make new dir within public that name is catetgoryImage;
                Storage::disk('public')->makeDirectory('category/slider');

            }


            //            resize image for category  slider image
            $categorySlider = Image::make($image)->resize(500,333)->save();

            Storage::disk('public')->put('category/slider/'.$filename, $categorySlider );
        } else {
            $filename = 'default.png';
        }


//        now save
        $categoryModel = new Category;
        $categoryModel->name = $request->categoryName;
        $categoryModel->slug = $slug;
        $categoryModel->image = $filename;
        $categoryModel->save();

        Toastr::success('CATEGORY SUCCESSFULLY CREATED', 'Success');
        return redirect()->route('admin.category.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'categoryName' =>  'required',
            'categoryImage' => 'mimes:jpeg,bmp,png,jpg'
        ]);
//         name of file
        $image = $request->file('categoryImage');
//        slug
        $slug = str_slug($request->categoryName, '-');
        //         filename

//        GET THRE CATEGORY id
        $categoryId =  Category::findOrFail($id);

        if (isset($image)) {
//            making uniqe namme for uploaded file
            $currentDate = Carbon::now()->toDateString();
//            gettong tghe new unique name for image
            $filename = $slug.'-'.$currentDate.'-'. uniqid().'.'.$image->getClientOriginalExtension();

//        now check the category dir exist or nor

            if (!Storage::disk('public')->exists('category')) {
//                if diir not exist than make new dir within public that name is catetgoryImage;
                Storage::disk('public')->makeDirectory('category');
//
            }

//            if old image exist than than rremove that image
            if (Storage::disk('public')->exists('category/'. $categoryId->image)) {
                Storage::disk('public')->delete('category/'.$categoryId->image);
            }



//            resize image for category image
            $category = Image::make($image)->resize(1600,479)->save();

            Storage::disk('public')->put('category/'. $filename, $category );



//        now check tthe cateegory slider dir exist or not for update

            if (!Storage::disk('public')->exists('category/slider')) {
//                if diir exist than make new dir within public that name is catetgoryImage;
                Storage::disk('public')->makeDirectory('category/slider');
            }


//            if category's slider exist than delete rhat

            if (Storage::disk('public')->exists('category/slider/'. $categoryId->image )) {
//                if diir exist than make new dir within public that name is catetgoryImage;
                Storage::disk('public')->delete('category/slider/'. $categoryId->image );

            }


            //            resize image for category  slider image
            $categorySlider = Image::make($image)->resize(500,333)->save();

            Storage::disk('public')->put('category/slider/'.$filename, $categorySlider );
        } else {
            $filename = $categoryId->image; // is user does not choose any pic
        }


//        now updat

        $result = Category::where('id', $id)
            ->update(
                [
                    'name' => $request->categoryName ,
                    'slug' =>  $slug,
                    'image' => $filename
                ]
            );




        Toastr::success('CATEGORY SUCCESSFULLY UPDATED', 'Success');
        return redirect()->route('admin.category.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


//        also delete the existing  category imagge
        $fetchStoredImage = Category::findOrFail($id);

        if (Storage::disk('public')->exists('category/'.$fetchStoredImage->image)) {
            Storage::disk('public')->delete('category/'.$fetchStoredImage->image);
        }



//        also delete the existing  category imagge slider

        if (Storage::disk('public')->exists('category/slider/'.$fetchStoredImage->image)) {
            Storage::disk('public')->delete('category/slider/'.$fetchStoredImage->image);
        }

//        finally delete the all record;

        $category = Category::where('id', $id )->firstOrFail();
        $category->forceDelete();
//        Toastr::success('TAGS SUCCESSFULLY DELETED', 'Success');
        return redirect()->back();
    }






}
