<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;

class UserController extends Controller
{

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->name) {
            $user->name = $request->name;
        }

        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }
}
