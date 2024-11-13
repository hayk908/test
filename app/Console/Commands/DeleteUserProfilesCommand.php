<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUserProfilesCommand extends Command
{
    protected $signature = 'delete:profile';

    protected $description = 'Delete user profiles';

    public function handle(): void
    {
        $userId = $this->ask('Введите ID пользователя, профиль которого нужно удалить');

        if (!is_numeric($userId) || $userId <= 0) {
            $this->error('Неверный формат ID. Пожалуйста, введите положительное число.');
            return;
        }

        $user = User::find($userId);

        if ($user) {
            if($user->profile) {
                $user->profile->delete();
                $this->info("профил ползватела c id {$userId} был удалон");
            }else {$this->info("ползвател с id {$userId} нет профила");}
        } else {
            $this->error("Пользователь с ID {$userId} не найден.");
        }
    }
}