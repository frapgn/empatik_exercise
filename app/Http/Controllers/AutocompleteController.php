<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function fetch(Request $request)
    {
        if ($request->input('query')) {
            $query = $request->input('query');
            $data = DB::table('projects')
                    ->where('name', 'like', "{$query}%")
                    ->get();

            return response()->json($data);
        }
    }
}
