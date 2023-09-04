<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private $name = 'Category';

    public function __construct(Category $category){
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [
            'paginate' => $request->paginate,
            'per_page' => $request->per_page,
            'order_by' => $request->order_by,
            'keyword' => $request->keyword,
        ];

	    $response = $this->category;

        if(isset($data['keyword'])){
			$response = $response->where('name', 'LIKE', '%' . $data['keyword']. '%');
		}

		if(isset($data['order_by'])){
			$response = $response->orderBy('id', $data['order_by']);
		}

		if($data['paginate']){
			return $response = $response->paginate($data['per_page'])->toArray();
		}
		$response = $response->get()->toArray();

        return response()->json(
        [
            "response" => $this->name . ' Successfully Fetched.', 
            "data" => $response,
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            "name" => $request->name,
        ];

        $response = $this->category->create($data);
        $response = $response->toArray();

        return response()->json(
        [
            "response" => $this->name . ' Successfully Created.', 
            "data" => $response,
            "status" => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = $this->category->find($id);

        return response()->json(
        [
            "response" => $this->name . ' Successfully Feteched.', 
            "data" => $response,
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = [
            "name" => $request->name,
        ];


        $response = $this->category->find($id);
        $response->fill($data)->save();

        $response = $this->category->find($id);

        return response()->json(
        [
            "response" => $this->name . ' Successfully Updated.', 
            "data" => $response,
            "status" => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = $this->category->destroy($id);

        return response()->json(
        [
            "response" => $this->name . ' Successfully Deleted.', 
            "data" => $response,
            "status" => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }
}
