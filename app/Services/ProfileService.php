<?php



namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileService
{
    /**
     *
     * @param array<string, mixed> $data
     * @return object
     */
    public function createOrUpdateProfile(array $data): object
    {
        /** @var User $user */
        $user = Auth::user();

        $profile = Profile::query()->where('user_id', $user->id)->first();

        if ($profile === null) {
            $profileData = [
                'user_id' => $user->id,
                'bio' => $data['bio'],
                'avatar' => $data['avatar'],
            ];
            $createdProfile = Profile::query()->create($profileData);

            return $createdProfile->refresh();
        } else {
            $profile->update([
                'avatar' => $data['avatar'],
                'bio' => $data['bio'],
            ]);
            return $profile;
        }
    }

    /**
     *
     * @return array<string, mixed>
     */
    public function getProfile(): array
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = Profile::query()->where('user_id', $user->id)->first();

        return [
            'user' => $user->name,
            'profile' => $profile,
        ];
    }

    /**
     *
     * @param int $id
     * @return Builder|Model
     */
    public function getProfileById(int $id): Builder|Model
    {
        $profile = Profile::query()->where('id', $id)->first();

        if (is_null($profile)) {
            throw new NotFoundHttpException('Profile not found');
        }

        return $profile;
    }
}
