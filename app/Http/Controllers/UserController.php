<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 20);

        return JsonResource::collection(User::query()->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all());

        return response()->json([
            "id" => $user->id,
            "message" => "Usuário criado"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new JsonResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        $user->fill($request->all());
        $user->save();

        return response()->json([
            "message" => 'Usuário atualizado'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            "message" => "Usuário deletado"
        ]);
    }

    public function login(Request $request)
    {
        $token = $this->userModel->login($request->email, $request->password);

        return response()->json([
            "token" => $token->plainTextToken
        ]);
    }
}
