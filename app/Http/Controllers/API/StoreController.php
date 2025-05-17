<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function fetchStores()
    {
        $stores = Store::select('id', 'name')->get(); // 必要なデータだけ取得
        return response()->json(['stores' => $stores]);
    }
}
