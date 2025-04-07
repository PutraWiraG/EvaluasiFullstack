<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *     title="Evaluasi Fullstack API",
 *     version="1.0.0",
 *     description="Dokumentasi API Evaluasi Fullstack Laravel",
 *     @OA\Contact(
 *         email="putra22wir@gmail.com"
 *     )
 * )
 */


class UserController extends Controller
{

   /**
 * @OA\Get(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Ambil semua data user",
 *     description="Mengembalikan semua data user dari database",
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil ambil data user",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="true"),
 *             @OA\Property(property="message", type="string", example="Data User"),
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="age", type="integer", example=20)
 *             ))
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Gagal ambil data user"
 *     )
 * )
 */
    public function index()
    {

        Log::info('Request Ambil Semua Data User.');
        try{

            $users = User::all();
            Log::info('Berhasil Ambil Semua Data User.');

            return response()->json([
                'status' => 'true',
                'message' => 'Data User',
                'data' => $users
            ], 200);

        }catch(Exception $e){
            Log::error('Gagal Mengambil Data User.' . $e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal Mengambil Data User',
                'errors' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
