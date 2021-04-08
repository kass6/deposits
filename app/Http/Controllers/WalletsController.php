<?php

namespace App\Http\Controllers;

use App\Http\Requests\RechargeBalanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WalletsController extends Controller
{

    /**
     * @param RechargeBalanceRequest $request
     * @return RedirectResponse
     */
    public function recharge(RechargeBalanceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Auth::user()->wallet->rechargeBalance($validated['recharge-balance']);

        return Redirect::to(route('dashboard'));
    }
}
