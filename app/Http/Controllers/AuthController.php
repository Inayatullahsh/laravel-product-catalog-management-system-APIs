<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\AuthenticateUserRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // public function register(StoreUserRequest $request)
    public function register(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $user = User::create($validated);
            $token = $user->createToken('ProductCatalogManagementSystem')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];

            DB::commit();

            return response($response, 201);
        } catch (Throwable $e) {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 422);
        }
    }

    public function authenticate(AuthenticateUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            if (!Auth::attempt($validated)) {
                return response([
                    'message' => 'Your Email or Password is incorrect. Try Again!'
                ], 401);
            }

            $token = $request->user()->createToken('ProductCatalogManagementSystem')->plainTextToken;

            DB::commit();
            return response([
                'user' => $request->user(),
                'token' => $token
            ], 201);
        } catch (Throwable $e) {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response([
                'message' => 'Logged Out!'
            ]);
        } catch (Throwable $e) {
            return response([
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
