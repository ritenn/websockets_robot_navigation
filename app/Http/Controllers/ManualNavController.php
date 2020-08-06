<?php

namespace App\Http\Controllers;


use App\Models\Configuration;

class ManualNavController extends Controller
{
    /**
     * @param Configuration $configuration
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Configuration $configuration)
    {
        return view("dashboard.navigation.manual.index")->with(compact(['configuration']));
    }
}
