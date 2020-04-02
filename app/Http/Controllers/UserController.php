<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('log')->only('index');

        $this->middleware('subscribed')->except('store');
    }

    /**
     * User index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //
    }

    /**
     * Show the profile for the given user.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view(
            'user.profile',
            [
                'user' => User::findOrFail($id)
            ]
        );
    }
}
