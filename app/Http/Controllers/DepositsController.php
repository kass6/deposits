<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepositRequest;
use App\Models\Deposit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DepositsController extends Controller
{

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        return view('deposits', [
            'deposits' => Deposit::query()
                ->where('user_id', Auth::id())
                ->paginate(5)
        ]);
    }

    /**
     * @param CreateDepositRequest $request
     * @return RedirectResponse
     */
    public function recharge(CreateDepositRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Deposit::create($validated['recharge-deposit'], Auth::user()->wallet);

        return Redirect::to(route('dashboard'));
    }
}
