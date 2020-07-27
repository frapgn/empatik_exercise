<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function fetch_projects(Request $request)
    {
        if ($request->input('query')) {
            $query = $request->input('query');
            $data = DB::table('projects')
                    ->where('name', 'like', "{$query}%")
                    ->get();

            return response()->json($data);
        }
    }

    public function fetch_services(Request $request)
    {
        if ($request->input('query')) {
            $query = $request->input('query');
            $data = DB::table('services')
                    ->where('name', 'like', "{$query}%")
                    ->get();

            return response()->json($data);
        }
    }
}
