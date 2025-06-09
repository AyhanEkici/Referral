<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Freestays\Referral\ReferralService;

class ReferralController extends Controller
{
    protected $service;

    public function __construct(ReferralService $service)
    {
        $this->service = $service;
    }

    public function generate(Request $request)
    {
        $code = $this->service->createCode($request->user()->id);
        return response()->json(['code' => $code]);
    }

    public function register(Request $request)
    {
        $this->service->handleReferral($request->input('code'), $request->user()->id);
        return response()->json(['status' => 'ok']);
    }
}
