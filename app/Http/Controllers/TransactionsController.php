<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        return view('transactions', [
            'transactions' => Transaction::query()
                ->where('user_id', Auth::id())
                ->orderBy('updated_at', 'DESC')
                ->paginate(5)
        ]);
    }

}
