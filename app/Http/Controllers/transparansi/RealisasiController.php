<?php

namespace App\Http\Controllers\transparansi;

use App\Http\Controllers\Controller;
use App\Services\BudgetDataService;
use Illuminate\View\View;

class RealisasiController extends Controller
{
    public function __invoke(BudgetDataService $budgetData): View
    {
        $budget = $budgetData->all();
        $reportPdfs = $budgetData->reportPdfs();

        return view('pages.realisasi', compact('budget', 'reportPdfs'));
    }
}
