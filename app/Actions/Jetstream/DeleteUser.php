<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        // Hapus token hanya jika relasi tokens ada
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }
        $user->delete();
    }
}