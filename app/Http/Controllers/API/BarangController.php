<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BarangRequest;
use App\Http\Resources\BarangResource;
use App\Models\Barang;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BarangController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return BarangResource::collection(Barang::latest()->paginate(10));
    }

    public function store(BarangRequest $request): BarangResource|\Illuminate\Http\JsonResponse
    {
        try {
            $barang = Barang::create($request->validated());
            return new BarangResource($barang);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Barang $barang): BarangResource
    {
        return BarangResource::make($barang);
    }

    public function update(BarangRequest $request, Barang $barang): BarangResource|\Illuminate\Http\JsonResponse
    {
        try {
            $barang->update($request->validated());
            return new BarangResource($barang);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Barang $barang): \Illuminate\Http\JsonResponse
    {
        try {
            $barang->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
