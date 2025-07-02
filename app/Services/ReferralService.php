<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    /**
     * Generate a unique referral code for a user.
     */
    public function createCode(int $userId): string
    {
        // Ensure the user doesn't already have a code
        $existing = DB::table('referral_codes')->where('user_id', $userId)->first();
        if ($existing) {
            return $existing->code;
        }

        // Generate a unique code
        do {
            $code = Str::upper(Str::random(8));
            $exists = DB::table('referral_codes')->where('code', $code)->exists();
        } while ($exists);

        DB::table('referral_codes')->insert([
            'user_id' => $userId,
            'code' => $code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $code;
    }

    /**
     * Handle a new signup using a referral code.
     */
    public function handleReferral(string $code, int $newUserId): void
    {
        $referral = DB::table('referral_codes')->where('code', $code)->first();
        if (!$referral) {
            throw new \Exception('Invalid referral code.');
        }
        // Prevent self-referral or duplicate referral
        if ($referral->user_id == $newUserId) {
            throw new \Exception('Cannot refer yourself.');
        }
        $alreadyReferred = DB::table('referrals')
            ->where('referred_id', $newUserId)
            ->exists();
        if ($alreadyReferred) {
            throw new \Exception('User already referred.');
        }
        DB::table('referrals')->insert([
            'referrer_id' => $referral->user_id,
            'referred_id' => $newUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Get the number of referrals for a user.
     */
    public function countReferrals(int $userId): int
    {
        return DB::table('referrals')->where('referrer_id', $userId)->count();
    }
}
