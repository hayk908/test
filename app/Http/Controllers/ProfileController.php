<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilRequestName;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileController extends Controller
{
    public function createProfile(ProfilRequestName $profileRequestName): JsonResponse
    {


        $user = Auth::user();

        $userId = Auth::id();

        $profile = $user->profile;

        $data = $profileRequestName->toArray();

        if ($profile === null) {

            $profileData = [
                'user_id' => $userId,
                'bio' => $data['bio'],
                'avatar' => $data['avatar'],
            ];

            $createdProfile = Profile::query()->create($profileData);

            return response()->json($createdProfile);
        } else {
            Profile::query()->where('user_id', $userId)->
            update(['avatar' => $data['avatar'], 'bio' => $data['bio']]);
            return response()->json([
                "message" => "Profile updated",
            ]);
        }
    }

    public function getProfile(): JsonResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        return response()->json([
            'user' => $user->name,
            'profile' => $profile,
        ]);
    }

    public function getProfileById(int $id): JsonResponse
    {
        $profile = Profile::query()->where('id', $id)->first();

        if (is_null($profile)) {
            throw new NotFoundHttpException('not found profile');
        }

        return response()->json([
            'profile' => $profile,
        ]);
    }
}
