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
        ->where('name', 'LIKE', '%' . $request->search . "%")
        ->get());
    }

    public function total(Request $request){
        return response(Restaurant::where('name', 'LIKE', '%' . $request->search . "%")
            ->count());
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
//        if (!Gate::allows('update-restaurant')) {
//            return response()->json([
//                'code' => 1,
//                'message' => 'У вас нет прав на редактирование ресторана',
//            ]);
//        }
        $validated = $request->validate([
            'name'    => 'required|max:255|unique:restaurants,name,' . $id,
            'image'   => 'nullable|file|image|max:2048',
        ]);
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->name = $validated['name'];
            if ($request->hasFile('image')) {
                try{
                    if ($restaurant->picture_url) {
                        $baseUrl = Storage::disk('s3')->getClient()->getEndpoint();
                        $oldPath = str_replace($baseUrl, '', $restaurant->picture_url);
                        if (Storage::disk('s3')->exists($oldPath)) {
                            Storage::disk('s3')->delete($oldPath);
                        }
                    }
                    $file = $request->file('image');
                    $fileName = rand(1, 100000) . '_' . $file->getClientOriginalName();
                    $path = Storage::disk('s3')->putFileAs('restaurant_pictures', $file, $fileName);
                    $restaurant->picture_url = Storage::disk('s3')->url($path);
                } catch (\Exception $e){
                    return response()->json(['message' => 'Error uploading file to S3: ',
                        'error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]], 500);
                }
            }
            $restaurant->save();
            return response()->json([
                'code' => 0,
                'message' => 'Ресторан успешно обновлен',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка при обновлении: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('delete-restaurant')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на удаление ресторана',
            ], 401);
        }
        $restaurant = Restaurant::find($id);
        if ($restaurant->favorites()->count()) {
            return response()->json(['code' => 1, 'error' => 'Нельзя удалять непустой ресторан']);
        }
        $deleted = Restaurant::destroy($id);
        if ($deleted === 0 ) {
            return response()->json(['code'=> 1, 'error' => 'Ресторан не найден']);
        }
        return response()->json(['code' => 0, 'message' => 'Ресторан успешно удален']);
    }
}
