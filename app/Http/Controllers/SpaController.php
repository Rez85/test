<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SpaController
 *
 * @package App\Http\Controllers
 */
class SpaController extends Controller
{
    public function index()
    {
        return view(
            'spa'
        );
    }
}
