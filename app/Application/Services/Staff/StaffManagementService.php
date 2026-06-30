<?php

namespace App\Application\Services\Staff;

use App\Domain\Identity\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StaffManagementService
{
    public function listStaff(): Collection
    {
        return User::query()
            ->where('role', '!=', UserRole::Admin->value)
            ->select('id', 'role', 'name', 'email', 'department')
            ->get();
    }

    public function findStaff(int $id): ?User
    {
        return User::find($id);
    }

    public function updateStaff(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);
        $user->update([
            'name' => $data['name'],
            'department' => $data['department'],
            'role' => $data['role'],
            'email' => $data['email'],
        ]);

        return $user;
    }

    public function createStaff(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'department' => $data['department'],
            'role' => $data['role'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function deleteStaff(int $id): void
    {
        User::findOrFail($id)->delete();
    }
}
