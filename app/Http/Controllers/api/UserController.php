<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
 * @OA\Post(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Simpan data user baru",
 *     description="Menyimpan data user baru ke database.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "age"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *             @OA\Property(property="age", type="integer", example=25)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Data berhasil disimpan",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Berhasil Menyimpan Data"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="string", example="b0e3b1c4-7f8f-41b2-88fb-12f1a563ebcb"),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="age", type="integer", example=25),
 *                 @OA\Property(property="created_at", type="string", example="2025-04-07T10:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", example="2025-04-07T10:00:00.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Validasi gagal",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Validasi Gagal!"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Gagal menyimpan data",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Gagal Menyimpan Data!"),
 *             @OA\Property(property="errors", type="string", example="SQLSTATE[23000]...")
 *         )
 *     )
 * )
 */

    public function store(Request $request)
    {
        Log::info('Request Simpan Data Users');
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age'   => 'required|integer|min:1'
        ]);

        if($validator->fails()){
            Log::error('Gagal Menyimpan Data. - '. $validator->errors());
            return response()->json([
                'status' => 'false',
                'message' => 'Validasi Gagal!',
                'errors' => $validator->errors()
            ], 401);
        }

        try{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'age' => $request->age
            ]);

            Log::info('Berhasil Menyimpan Data');
            return response()->json([
                'status' => 'true',
                'message' => 'Berhasil Menyimpan Data',
                'data' => $user
            ], 200);

        }catch(Exception $e){
            Log::error('Gagal Menyimpan Data. - '. $e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal Menyimpan Data!',
                'errors' => $e->getMessage()
            ], 500);
        }

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
