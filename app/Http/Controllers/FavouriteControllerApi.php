<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;

class FavouriteControllerApi extends Controller
{
    public function index(Request $request)
    {
        return response(Favourite::with('restaurant')
            ->where('user_id', auth()->id())
            ->limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
            ->get());
    }

    public function total()
    {
        return response( Favourite::where('user_id', auth()->id())->count());
    }
}
