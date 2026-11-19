<?php

namespace App\Http\Controllers\transparansi;

use App\Http\Controllers\Controller;
use App\Services\BudgetDataService;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    public function __invoke(BudgetDataService $budgetData): View
    {
        $budget = $budgetData->all();

        return view('pages.apbdes', compact('budget'));
    }
}
