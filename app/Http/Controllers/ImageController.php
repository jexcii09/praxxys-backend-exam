<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Config;

class ImageController extends Controller
{
    private $name = 'Image';

    public function __construct(Image $image){
        $this->image = $image;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $host = $request->getSchemeAndHttpHost();
        $path = $host . '/public/images/';

        if($request->hasFile('file')){
            $file = $request->file;

            //get file name with extenstion
            $fileNameWithExt = $file->getClientOriginalName();

            //get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get extension
            $extension = $file->getClientOriginalExtension();

            //file to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //upload to store
            $file->move('public/images', $fileNameToStore);


            $data = [
                'product_id' => $request->product_id,
                'file_name' => $fileNameToStore,
                'path' => $path . $fileNameToStore,
            ];
        
            $response = $this->image->create($data);
            $response = $response->toArray();

            return response()->json(
            [
                "response" => $this->name . ' Successfully Created.', 
                "data" => $response,
                "status" => Response::HTTP_CREATED
            ], Response::HTTP_CREATED);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = $this->image->destroy($id);

        return response()->json(
        [
            "response" => $this->name . ' Successfully Deleted.', 
            "data" => $response,
            "status" => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }
}
