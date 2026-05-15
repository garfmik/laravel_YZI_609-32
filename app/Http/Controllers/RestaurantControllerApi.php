<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class RestaurantControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response(Restaurant::limit($request->perpage ?? 5)
        ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
        ->get());
    }

    public function total(){
        return response(Restaurant::all()->count());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        if (! Gate::allows('create-restaurant')) {
//            return response()->json([
//                'code' => 1,
//                'message' => 'У вас нет прав на добавление ресторана',
//            ]);
//        }

        $validated = $request->validate([
            'name'    => 'required|max:255|unique:restaurants',
            'image' => 'required|file',
        ]);

        $file = $request->file('image');
        $fileName = rand(1, 100000) . '_' . $file->getClientOriginalName();

        try {
            $path = Storage::disk('s3')->putFileAs('restaurant_pictures', $file, $fileName);
            $fileUrl = Storage::disk('s3')->url($path);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка загрузки файла в хранилище S3',
            ]);
        }
        $restaurant = new Restaurant($validated);
        $restaurant->picture_url = $fileUrl;
        $restaurant->save();

        return response()->json([
            'code' => 0,
            'message' => 'Ресторан успешно добавлен',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Restaurant::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
