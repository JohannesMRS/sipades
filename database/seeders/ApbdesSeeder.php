<?php

namespace Database\Seeders;

use App\Models\BudgetActivity;
use App\Models\BudgetField;
use App\Models\BudgetFinancing;
use App\Models\BudgetIncome;
use App\Models\BudgetYear;
use Illuminate\Database\Seeder;

class ApbdesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = config('sipades');

        foreach ($data['bidang'] ?? [] as $code => $name) {
            BudgetField::query()->updateOrCreate(['code' => $code], ['name' => $name]);
        }

        foreach (($data['years'] ?? []) as $yearValue => $yearData) {
            $year = BudgetYear::query()->updateOrCreate(['year' => (int) $yearValue], ['is_active' => true]);

            foreach ($yearData['income'] ?? [] as $row) {
                BudgetIncome::query()->updateOrCreate([
                    'budget_year_id' => $year->id,
                    'group' => $row[0],
                    'name' => $row[1],
                ], ['budget_amount' => $row[2], 'realized_amount' => $row[3]]);
            }

            foreach ($yearData['financing'] ?? [] as $row) {
                BudgetFinancing::query()->updateOrCreate([
                    'budget_year_id' => $year->id,
                    'type' => $row[0],
                    'name' => $row[1],
                ], ['budget_amount' => $row[2], 'realized_amount' => $row[3]]);
            }

            foreach ($yearData['activities'] ?? [] as $row) {
                $field = BudgetField::query()->where('code', $row[1])->firstOrFail();
                BudgetActivity::query()->updateOrCreate([
                    'budget_year_id' => $year->id,
                    'name' => $row[0],
                    'budget_field_id' => $field->id,
                ], ['budget_amount' => $row[2], 'realized_amount' => $row[3], 'status' => $row[4]]);
            }
        }
    }
}
