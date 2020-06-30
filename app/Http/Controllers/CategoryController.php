<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller
{

    public function allCategory(Request $request)
    {

        $data = Category::select('category.id', 'category.name', 'category.slug', 'category.description', 'category.parent_id', 'c.name as parentCategory')
            ->leftjoin('category as c', 'c.id', 'category.parent_id');

        $products = $data->get();

        return response()->json([
            'status_code' => 'success',
            'data'        => $products,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $category = Category::select('category.*', 'c.name as parentCategory')
        //     ->leftjoin('category as c', 'c.id', 'category.parent_id')->latest()->get();

        $category = Category::select('id', 'name', 'parent_id')->get();

        $categoryArray = $this->categoryChild($category->toArray());

        $html = $this->getCategoryHtml($categoryArray);

        $data = [
            'categories'=> $category,
            'categoryArray' => $categoryArray,
            'html' => $html
        ];

        // print_r($categoryArray);
        return view('category.list', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryChild($category, $parent = NULL)
    {
        $mainCategory = array_filter($category, function($a)use($parent) {
                   return $a['parent_id'] == $parent;
               });

       if ($mainCategory) {
           foreach ($mainCategory as $key => $value) {
               $mainCategory[$key]['sub_category'] = $this->categoryChild($category, $value['id']);
           }
       }
       return $mainCategory;
    }

    public function getCategoryHtml($categoryData) 
    {
        $html = "";

        if ($categoryData) {
            $html .= "<ul>\n";
            
            foreach ($categoryData as $key => $category) {
                $html .= "<li> \n";
                $html .= "<span>". $category['name'] . "</span> \n";
                $html .= $this->getCategoryHtml($category['sub_category']);
                $html .= "</li> \n";
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            // 'name' => 'required|unique:category,name,' . $input['id'],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $result['status']      = 'validation';
            $result['name']        = $validator->errors()->first('name');
        } else {
            if (isset($input['id']) && !empty($input['id'])) {
                $category = Category::find($input['id']);
                $msg      = "Updated";
            } else {
                $category = new Category;
                $msg      = "Created";
            }

            $category->name        = isset($input['name']) ? $input['name'] : "";
            $category->slug        = Str::slug($input["name"], '-');
            $category->parent_id   = !empty($input['parent_id']) ? $input['parent_id'] : null;

            if ($category->save()) {
                $result['status']  = 'success';
                $result['message'] = 'Category ' . $msg . ' successfully';
                $result['id'] = $category->id;
            } else {
                $result['status']  = 'error';
                $result['message'] = 'error';
            }
        }
        echo json_encode($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();
        if (!empty($category)) {
            try {
                $category->delete();
                $result = ['status' => 'success', 'message' => 'Category deleted Successfully!!'];
            } catch (\Exception $e) {
                $result = ['status' => 'error', 'message' => 'You can not delete category having child category'];
            }
        } else {
            $result = ['status' => 'error', 'message' => 'Category not Found'];
        }

        echo json_encode($result);
    }

}
