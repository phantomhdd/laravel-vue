<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('created_at', 'desc')->get();
        return UserResource::collection($user);
    }

    public function store(Request $request)
    {
        $faker = Factory::create('id_ID');

        $user = User::create([
            'name' => $request->name,
            'email' => $faker->unique()->email,
            'password' => Hash::make('123456'),
        ]);

        return new UserResource($user);
    }

    public function update($id, Request $request)
    {
        $faker = Factory::create('id_ID');

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $faker->unique()->email,
            'password' => Hash::make('123456'),
        ]);
        return new UserResource($user);
    }

    public function delete($id)
    {
        User::destroy($id);
        return response('Delete Success');
    }
}
