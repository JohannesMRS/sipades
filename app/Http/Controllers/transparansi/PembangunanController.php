<?php

namespace App\Http\Controllers\transparansi;

use App\Http\Controllers\Controller;
use App\Services\ProjectPublicService;
use Illuminate\View\View;

class PembangunanController extends Controller
{
    public function __invoke(ProjectPublicService $service): View
    {
        return view('pages.pembangunan', ['projects' => $service->projects()]);
    }
}
