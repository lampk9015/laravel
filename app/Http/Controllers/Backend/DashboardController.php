<?php

namespace App\Http\Controllers\Backend;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // dd(
        //     \Auth::adminUser()->profile,
        //     // \App\Domains\Auth\Models\Admin::find(1)->profile,
        //     \App\Domains\Auth\Models\Admin::find(1),
        //     \App\Domains\Auth\Models\User::find(1)
        // );

        return view('backend.dashboard');
    }
}
