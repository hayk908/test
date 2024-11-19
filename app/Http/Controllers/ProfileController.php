<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequestName;
use App\Http\Resources\GetProfileByIdResources;
use App\Http\Resources\GetProfileResources;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use App\Models\Profile;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function createProfile(ProfileRequestName $profileRequestName): JsonResponse
    {
        $data = $profileRequestName->toArray();

        /** @var Profile $profile */
        $profile = $this->profileService->createOrUpdateProfile($data);

        assert($profile instanceof Profile);

        return response()->json([
            'profile' => $profile,
            'message' => $profile->wasRecentlyCreated ? "Profile created" : "Profile updated",
        ]);
    }

    public function getProfile(): GetProfileResources
    {
        $profileData = $this->profileService->getProfile();

        return new GetProfileResources($profileData);
    }

    public function getProfileById(int $id): GetProfileByIdResources
    {
        $profile = $this->profileService->getProfileById($id);

        return new GetProfileByIdResources($profile);
    }
}
