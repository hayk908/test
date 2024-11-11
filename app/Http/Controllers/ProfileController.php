<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequestName;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProfileController extends Controller
{
    public function createProfile(ProfileRequestName $profileRequestName): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $profile = Profile::query()->where('user_id', $user->id)->first();

        $data = $profileRequestName->toArray();

        if ($profile === null) {

            $profileData = [
                'user_id' => $user->id,
                'bio' => $data['bio'],
                'avatar' => $data['avatar'],
            ];

            $createdProfile = Profile::query()->create($profileData);

            return response()->json($createdProfile);
        } else {
            Profile::query()->where('user_id', $user->id)->
            update(['avatar' => $data['avatar'], 'bio' => $data['bio']]);
            return response()->json([
                "message" => "Profile updated",
            ]);
        }
    }

    public function getProfile(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = Profile::query()->where('user_id', $user->id)->first();

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
