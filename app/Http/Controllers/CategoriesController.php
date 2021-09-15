<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Category::with('parent')->withCount('products')->Paginate(10);

      //$categories = Category::latest()->paginate(10);
       
        return view('categories.index',compact('categories'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        return view('categories.create', [
            'category' => new Category(),
            'parents' => $parents,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|min:3|max:255',
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
            'image' => 'nullable|image|max:1232896|dimensions:min_width=100,min_height=100',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // UploadedFile
            $image_path = $file->store('/uploads', 'public');
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $request->input('parent_id'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'image_path' => $image_path,
        ]);


        return redirect('categories')->with('success','Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$category = Category::where('id', '=', $id)->first();
        $category = Category::findOrFail($id);
        /*if (!$category) {
            abort(404);
        }*/
        return view('Categories.show', [
            'category' => $category,
        ]);
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
        $parents = Category::where('id', '<>', $id)->get();

        return view('categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
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

        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
            'image' => 'nullable|image|max:1232896|dimensions:min_width=100,min_height=100',
        ]);

        $category = Category::findOrFail($id);

        $old_image = $image_path = $category->image_path;

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // UploadedFile
            $image_path = $file->store('/uploads', 'public');
            //
        }

        // $rules = [
        //     'name' => 'required|string|min:5|max:255',
        //     'parent_id' => 'nullable|int|exists:Category,id',
        //     'description' => 'nullable|string',
        //     'status' => 'in:active,inactive',
        // ];
        // $data = $request->all();
        //$validator = Validator::make($data, $rules);
        //$validator->validate();
        //$validator->fails(); // true or false
        //$validator->errors(); // Return all error messages

        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $request->input('parent_id'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'image_path' => $image_path,
        ]);

        //
        if ($old_image && $old_image != $image_path) {
            Storage::disk('public')->delete($old_image);
        }

        /*$category->forceFill([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $request->input('parent_id'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ])->save();

        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->save();*/

        //session()->put('success', 'Categories updated!');

        return redirect('categories')
        ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

         //Category::destroy($id);
        
        // Category::where('id', '=', $id)->delete();

        $category = Category::findOrFail($id);//1-ايجاد الملف
        $category->delete();//2-تنفيذ العملية بشكل ناجح

        if ($category->image_path) {// حذف الصورة الخاصة بالكاتجرو من ملفاتنا
            Storage::disk('public')->delete($category->image_path);
        }
        //With -> تخزين قيمة في السشن للفلاش مسج 
        //key -> 'success'   , valu ->category deleted
        //
        return redirect('categories')->with('success','Category deleted successfully');
    }


}
