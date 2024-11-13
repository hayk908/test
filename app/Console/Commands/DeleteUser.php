<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    protected $signature = 'delete:user';

    protected $description = 'Removes records that have the enable field equal to 2';

    public function handle(): void
    {
       $deletedCount = User::query()->where('enable', 2)->delete();

      $this->info($deletedCount . " записей с полем enable = 2 было удалено.");
    }
}
