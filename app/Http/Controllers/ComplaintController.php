<?php

namespace App\Http\Controllers;

use App\Models\Complaints;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        return response()->json(Complaints::all());
    }

    public function storeMarker(Request $request)
    {
        $complaint = Complaints::create($request->all());
        return response()->json($complaint);
    }

    public function storePolygon(Request $request)
    {
        $complaint = Complaints::create([
            'title' => $request->title,
            'description' => $request->description,
            'polygon' => json_encode($request->polygon)
        ]);

        return response()->json($complaint);
    }

    public function storeDrawing(Request $request)
    {
        $data = Complaints::create([
            'title' => $request->title,
            'description' => $request->description,
            'geometry' => $request->geometry,
            'type' => $request->type
        ]);

        return response()->json($data);
    }
}
