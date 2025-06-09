<?php

namespace Freestays\Referral;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReferralService
{
    /**
     * Generate a unique referral code for a user.
     */
    public function createCode(int $userId): string
    {
        $code = Str::upper(Str::random(8));
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
        if ($referral) {
            DB::table('referrals')->insert([
                'referrer_id' => $referral->user_id,
                'referred_id' => $newUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Get the number of referrals for a user.
     */
    public function countReferrals(int $userId): int
    {
        return DB::table('referrals')->where('referrer_id', $userId)->count();
    }
}
