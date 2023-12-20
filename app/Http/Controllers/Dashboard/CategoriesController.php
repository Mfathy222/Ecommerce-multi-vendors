<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        // $parents=new Category();

        return view('dashboard.categories.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'parents'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $clean_data = $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) is required',
            'name.unique' => 'This name is already exists!'
        ]);


        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);
        $parents = Category::all();
        $category = new Category();
        return Redirect::route('dashboard.categories.index', compact('category', 'parents'))->with('success', 'category created successfuly');
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

        $category = Category::findorfail($id);
        $parent = Category::where('id', '!=', $id)
            ->where(function ($query) use ($id) {
                $query->wherenull('parent_id')
                    ->orwhere('parent_id', '!=', $id);

            })

            ->get();
        $parents = new Category();

        return view('dashboard.categories.edit', compact('parents', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //$request->validate(Category::rules($id));
        $category = Category::findorfail($id);
        $old_image = $category->image;
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);
        $category->update($data);
        if ($old_image && $data['image']) {
            Storage::disk('uploads')->delete($old_image);
        }

        return Redirect::route('dashboard.categories.index')->with('success', 'category updated successfuly');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $category->delete();

        if ($category->image) {
            Storage::disk('publice')->delete($category->image);
        }
        // Category::destroy($id);


        return Redirect::route('dashboard.categories.index')->with('success', 'category deleted successfuly');

    }
    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $file = $request->file('image'); // UploadedFile Object

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }
}


?>