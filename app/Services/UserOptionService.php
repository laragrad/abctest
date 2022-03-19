<?php

namespace App\Services;

use App\Models\User;
use DB;

class UserOptionService
{

    /**
     *
     * @param User $user
     * @param array $options
     * @return bool
     */
    public function changeOptions(User $user, array $options = []): bool
    {
        if (isset($options['language'])) {
            $user->languageOption = $options['language'];
        }
        if (isset($options['timezone'])) {
            $user->timezoneOption = $options['timezone'];
        }

        if (! $user->isDirty('options')) {
            return false;
        }

        DB::transaction(function () use ($user) {
            $user->save();
        });

        return true;
    }
}