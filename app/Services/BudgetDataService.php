<?php

namespace App\Services;

use App\Models\BudgetField;
use App\Models\BudgetYear;

class BudgetDataService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function all(): array
    {
        $fields = BudgetField::query()->orderBy('code')->get(['code', 'name'])->mapWithKeys(fn (BudgetField $field): array => [$field->code => $field->name])->all();

        $years = BudgetYear::query()->where('is_active', true)->with([
            'incomes:id,budget_year_id,group,name,budget_amount,realized_amount',
            'financing:id,budget_year_id,type,name,budget_amount,realized_amount',
            'activities:id,budget_year_id,budget_field_id,name,budget_amount,realized_amount,status',
            'activities.field:id,code',
        ])->orderByDesc('year')->get()->mapWithKeys(function (BudgetYear $year): array {
            return [$year->year => [
                'income' => $year->incomes->map(fn ($row): array => [$row->group, $row->name, (int) $row->budget_amount, (int) $row->realized_amount])->values()->all(),
                'financing' => $year->financing->map(fn ($row): array => [$row->type, $row->name, (int) $row->budget_amount, (int) $row->realized_amount])->values()->all(),
                'activities' => $year->activities->map(fn ($row): array => [$row->name, (int) $row->field->code, (int) $row->budget_amount, (int) $row->realized_amount, $row->status])->values()->all(),
            ]];
        })->all();

        return ['bidang' => $fields, 'years' => $years];
    }

    public function reportPdfs(): array
    {
        return BudgetYear::query()
            ->whereNotNull('report_pdf')
            ->pluck('report_pdf', 'year')
            ->map(fn (?string $path): string => str_starts_with((string) $path, 'http')
                ? (string) $path
                : '/storage/'.ltrim((string) $path, '/'))
            ->all();
    }
}
