<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all(); // $users = User::all();
        $currentPage = $request->get('current_page') ?? 1;
        $regsPerPage = 3;

        $skip = ($currentPage - 1) * $regsPerPage;

        $users = User::skip($skip)->take($regsPerPage)->orderByDesc('id')->get();

        return response()->json($users->toResourceCollection(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = ($request->validated()); // dd($request->all()) Apenas para depuração, exibe os dados recebidos na requisição

        try {
            $user = new User(); 
            $user->fill($data); // Preenche o modelo com os dados validados
            $user->password = Hash::make(123);
            $user->save(); // Salva o usuário no banco de dados
            return response()->json($user->toResource(), 201);
        } catch(Exception $ex) {
            return response()->json([
                'error' => 'Falha ao inserir usuário'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id); // findOrFail lança uma exceção se o usuário não for encontrado
            return response()->json($user->toResource());
        } catch(Exception $e) {
            return response()->json(['error' => 'Falha ao buscar usuário'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $user = User::findOrFail($id); 
            $user->update($data);

            return response()->json($user->toResource(), 200);
        } catch(Exception $ex) {
            return response()->json([
                'error' => 'Falha ao atualizar o usuário'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $removed = User::destroy($id);
            if (!$removed) {
                throw new Exception();
            }
            return response()->json(null, 204);
        } catch(Exception $ex) {
            return response()->json([
                'error' => 'Falha ao remover o usuário'
            ], 400);
        }
    }
}
