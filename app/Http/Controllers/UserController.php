<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadVerifyPhotoRequest;
use App\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getAuthUser(Request $request)
    {
        $user = User::where('api_token', '=', $request->token)->first();

        if ($user) {
            return fractal()
                ->item($user)
                ->transformWith(new UserTransformer)
                ->toArray();
        }

        return 'error';
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->address_city = $request->address_city;
        $user->address_area = $request->address_area;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->birth = $request->birth;

        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function uploadVerifyPhoto(UploadVerifyPhotoRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $verification = $user->verification;

        if ($request->hasFile('ID_card_photo') && $request->ID_card_photo->isValid()) {
            $fileName = 'user-'.$user->id.'-ID.'.$request->ID_card_photo->extension();
            $path = $request->ID_card_photo->storeAs('images', $fileName);
            $verification->ID_card_photo = $path;
        }

        if ($request->hasFile('driver_license_photo') && $request->driver_license_photo->isValid()) {
            $fileName = 'user-'.$user->id.'-driverLicense.'.$request->driver_license_photo->extension();
            $path = $request->driver_license_photo->storeAs('images', $fileName);
            $verification->driver_license_photo = $path;
        }

        if ($request->hasFile('personal_photo') && $request->personal_photo->isValid()) {
            $fileName = 'user-'.$user->id.'-personalPhoto.'.$request->personal_photo->extension();
            $path = $request->personal_photo->storeAs('images', $fileName);
            $verification->personal_photo = $path;
        }

        $verification->save();

        return fractal()
            ->item($user)
            ->parseIncludes(['user_verification'])
            ->transformWith(new UserTransformer)
            ->toArray();
    }
}
