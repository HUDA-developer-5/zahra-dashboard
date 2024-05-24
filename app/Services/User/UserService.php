<?php

namespace App\Services\User;

use App\DTOs\User\StoreContactusDTO;
use App\DTOs\User\UpdateUserProfileDTO;
use App\Enums\CommonStatusEnums;
use App\Enums\User\LanguageKeysEnum;
use App\Enums\User\UserStatusEnums;
use App\Helpers\FilesHelper;
use App\Models\Advertisement;
use App\Models\Contactus;
use App\Models\Nationality;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Support\Collection;

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
            'nationality_id' => $updateUserProfileDTO->nationality_id ?? $user->nationality_id
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

    public function createStripeCustomer(User $user): User
    {
        try {
            if (!empty($user->stripe_id)) {
                $user->createOrGetStripeCustomer();
            } else {
                $user->createAsStripeCustomer();
            }
            return $user;
        } catch (\Exception $exception) {
            $this->resetStripeCustomer($user);
            $user->createAsStripeCustomer();
            return $user;
        }
    }

    public function resetStripeCustomer(User $user): User
    {
        $user->stripe_id = null;
        $user->pm_type = null;
        $user->pm_last_four = null;
        $user->trial_ends_at = null;
        $user->save();
        return $user;
    }

    public function createSetupIntent(User $user)
    {
        return $user->createSetupIntent();
    }

    public function addPaymentMethod(User $user, string $paymentMethodId): bool
    {
        $stripeCustomer = $this->createStripeCustomer($user);
        $stripeCustomer->addPaymentMethod($paymentMethodId);
        return true;
    }

    public function listUserCards(User $user): Collection
    {
        $cards_list = collect();
        $default_card_id = '';
        if ($user->stripe_id) {
            if ($user->hasDefaultPaymentMethod()) {
                $default_card_id = $user->defaultPaymentMethod()->id;
            }
            if ($user->hasPaymentMethod()) {
                $cards = $user->paymentMethods();
                foreach ($cards as $card) {
                    $is_default = $card->id == $default_card_id;
                    $cards_list->push(
                        (object)[
                            'id' => $card->id,
                            'name' => $card->billing_details['name'],
                            'expire_month' => $card->card['exp_month'],
                            'expire_year' => $card->card['exp_year'],
                            'last_four_numbers' => $card->card['last4'],
                            'brand' => $card->card['brand'],
                            'is_default' => $is_default
                        ]
                    );
                }
            }

        }
        return $cards_list;
    }

    public function setDefault(User $user, string $paymentMethodId): bool
    {
        $payment_method = $user->findPaymentMethod($paymentMethodId);
        if ($payment_method) {
            $user->updateDefaultPaymentMethod($payment_method->id);
            return true;
        }
        return false;
    }

    public function deletePaymentMethod(User $user, string $paymentMethodId): bool
    {
        $payment_method = $user->findPaymentMethod($paymentMethodId);
        if ($payment_method) {
            $payment_method->delete();
            return true;
        }
        return false;
    }

    public function subscribeNewsletter(string $email): void
    {
        $newsletter = Newsletter::where('email', $email)->first();
        if (!$newsletter) {
            $newsletter = new Newsletter();
            $newsletter->email = $email;
            $newsletter->save();
        }
    }

    public function storeContactus(StoreContactusDTO $contactusDTO)
    {
        $contactus = new Contactus();
        $contactus->phone_number = $contactusDTO->phone_number;
        $contactus->name = $contactusDTO->name;
        $contactus->title = $contactusDTO->title;
        $contactus->email = $contactusDTO->email;
        $contactus->message = $contactusDTO->message;
        $contactus->save();
    }
}