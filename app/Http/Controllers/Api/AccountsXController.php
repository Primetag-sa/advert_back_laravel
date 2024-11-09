<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountsX;
use App\Models\AdXAnalytic;
use Illuminate\Http\Request;

class AccountsXController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('pageSize', 3);
        if ($perPage == 0) {
            $accounts = AccountsX::orderBy('id', 'desc')->get();
        } else {
            $accounts = AccountsX::orderBy('id', 'desc')->paginate($perPage);
        } // Nombre d'éléments par page

        foreach ($accounts as $key=>$account) {
            $active = AdXAnalytic::where('account_id',$account->account_id)->get();
            $accounts[$key]->countActive = sizeof($active);
        }

        return response()->json($accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountsX $accountsX)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountsX $accountsX)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountsX $accountsX)
    {
        //
    }
}
