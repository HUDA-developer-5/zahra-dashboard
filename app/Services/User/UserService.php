<?php

namespace App\Services\User;

use App\DTOs\User\UpdateUserProfileDTO;
use App\Enums\User\LanguageKeysEnum;
use App\Enums\User\UserStatusEnums;
use App\Helpers\FilesHelper;
use App\Models\User;

class UserService
{
    public function updateDefaultLanguage(User $user, LanguageKeysEnum $language): void
    {
        $user->update(['default_language' => $language->value]);
    }

    public function findByPhoneNumber(string $phoneNumber): ?User
    {
        return User::where('phone_number', '=', $phoneNumber)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', '=', $email)->first();
    }

    public function logout(User $user): void
    {
        $user->revokeTokens($user);
    }

    public function updatePassword(User $user, string $password): User
    {
        $user->update([
            'password' => bcrypt($password)
        ]);
        return $user;
    }

    public function changePassword(User $user, string $oldPassword, string $newPassword): bool
    {
        // check old password
        if ($user->isPasswordMatch($user, $oldPassword)) {
            // update user password
            $this->updatePassword($user, $newPassword);
            // revoke all tokens
            $user->revokeTokens($user);
            return true;
        }
        return false;
    }

    public function updateProfile(User $user, UpdateUserProfileDTO $updateUserProfileDTO): User
    {
        $user->update([
            'name' => $updateUserProfileDTO->name ?? $user->name,
            'email' => $updateUserProfileDTO->email ?? $user->email,
            'phone_number' => $updateUserProfileDTO->phone_number ?? $user->phone_number,
            'country_id' => $updateUserProfileDTO->country_id ?? $user->country_id
        ]);

        if ($updateUserProfileDTO->image && $updateUserProfileDTO->image->isFile()) {
            $image = FilesHelper::uploadImage($updateUserProfileDTO->image, $user::$destination_path);
            if ($image && $user->image) {
                FilesHelper::deleteImage($user->image);
            }
            $user->image = $image;
            $user->save();
        }
        return $user->refresh();
    }

    public function deleteAccount(User $user)
    {
        // revoke all tokens
        $user->revokeTokens($user);

        // change status to deleted
        $user->updateUserStatus(UserStatusEnums::Deleted, $user);

        $user->delete();
        return true;
    }
}