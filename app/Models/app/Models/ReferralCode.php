<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    protected $table = 'referral_codes';
    protected $fillable = ['user_id', 'code'];
}
