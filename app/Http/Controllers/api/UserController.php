<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
 * @OA\Get(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Ambil data user berdasarkan ID",
 *     description="Mengambil data user dari database berdasarkan UUID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID (UUID) dari user",
 *         @OA\Schema(type="string", format="uuid", example="a1b2c3d4-e5f6-7890-ab12-34567890cdef")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Data user ditemukan",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Data User Ditemukan"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="string", example="a1b2c3d4-e5f6-7890-ab12-34567890cdef"),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="age", type="integer", example=25),
 *                 @OA\Property(property="created_at", type="string", example="2025-04-07T12:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", example="2025-04-07T12:00:00.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Data user tidak ditemukan",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Data User Tidak Ditemukan!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Terjadi kesalahan saat mengambil data",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Gagal Mengambil Data!"),
 *             @OA\Property(property="errors", type="string", example="SQLSTATE[23000]...")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        Log::info('Request Ambil Data User Berdasarkan ID');
        try{

            $user = User::find($id);

            if(!$user){
                Log::warning("Data User Tidak Ditemukan.");
                return response()->json([
                    'status' => 'false',
                    'message' => 'Data User Tidak Ditemukan!'
                ], 404);
            }

            Log::info('Data User Ditemukan');
            return response()->json([
                'status' => 'true',
                'message' => 'Data User Ditemukan',
                'data' => $user
            ], 200);

        }catch(Exception $e){
            Log::error('Gagal Mengambil Data. - '. $e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal Mengambil Data!',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Update data user berdasarkan ID",
 *     description="Mengupdate data user berdasarkan ID. Email harus unik kecuali email milik user itu sendiri.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="UUID dari user yang ingin diupdate",
 *         @OA\Schema(type="string", format="uuid", example="a1b2c3d4-e5f6-7890-ab12-34567890cdef")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","age"},
 *             @OA\Property(property="name", type="string", example="John Updated"),
 *             @OA\Property(property="email", type="string", example="john.updated@example.com"),
 *             @OA\Property(property="age", type="integer", example=30)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil update data user",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Berhasil Update Data User"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="string", example="a1b2c3d4-e5f6-7890-ab12-34567890cdef"),
 *                 @OA\Property(property="name", type="string", example="John Updated"),
 *                 @OA\Property(property="email", type="string", example="john.updated@example.com"),
 *                 @OA\Property(property="age", type="integer", example=30),
 *                 @OA\Property(property="created_at", type="string", example="2025-04-07T12:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", example="2025-04-07T12:30:00.000000Z")
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
 *         response=404,
 *         description="Data user tidak ditemukan",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Data User Tidak Ditemukan")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Gagal update data user",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Gagal Update Data User!"),
 *             @OA\Property(property="errors", type="string", example="SQLSTATE[23000]...")
 *         )
 *     )
 * )
 */
    public function update(Request $request, $id)
    {

        Log::info('Request Update Data User.');
        $user = User::find($id);
        if(!$user){
            Log::warning('Data User Tidak Ditemukan!');
            return response()->json([
                'status' => 'false',
                'message' => 'Data User Tidak Ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'age'   => 'required|integer|min:1'
        ]);

        if($validator->fails()){
            Log::error('Validasi Gagal! - '. $validator->errors());
            return response()->json([
                'status' => 'false',
                'message' => 'Validasi Gagal!',
                'errors' => $validator->errors()
            ], 401);
        }

        try{

            $user->name = $request->name;
            $user->email = $request->email;
            $user->age = $request->age;
            $user->save();

            Log::info('Berhasil Update Data User.');
            return response()->json([
                'status' => 'true',
                'message' => 'Berhasil Update Data User',
                'data' => $user
            ], 200);

        }catch(Exception $e){
            Log::error('Gagal Update Data User. - '. $e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal Update Data User!',
                'errors' => $e->getMessage()
            ], 500);
        }

    }


    /**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Hapus data user berdasarkan ID",
 *     description="Menghapus data user dari database berdasarkan ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="UUID dari user yang ingin dihapus",
 *         @OA\Schema(type="string", format="uuid", example="a1b2c3d4-e5f6-7890-ab12-34567890cdef")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil hapus data user",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Berhasil Hapus Data")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Data user tidak ditemukan",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Data User Tidak Ditemukan!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Gagal hapus data user",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Gagal Hapus Data User"),
 *             @OA\Property(property="errors", type="string", example="SQLSTATE[23000]...")
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        Log::info("Request Delete Data User");
        $user = User::find($id);

        if(!$user){
            Log::warning('Data User Tidak Ditemukan!');
            return response()->json([
                'status' => 'false',
                'message' => 'Data User Tidak Ditemukan!'
            ], 404);
        }

        try{

            $user->delete();

            Log::info('Berhasil Hapus Data User');
            return response()->json([
                'status' => 'false',
                'message' => 'Berhasil Hapus Data'
            ], 200);


        }catch(Exception $e){
            Log::error('Gagal Hapus Data User. - '. $e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => 'Gagal Hapus Data User',
                'errors' => $e->getMessage()
            ], 500);
        }

    }
}
