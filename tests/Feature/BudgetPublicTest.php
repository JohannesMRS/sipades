<?php

namespace Tests\Feature;

use App\Models\BudgetActivity;
use App\Models\BudgetField;
use App\Models\BudgetYear;
use App\Services\BudgetDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetPublicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_budget_data_service_returns_config_shape(): void
    {
        $year = BudgetYear::query()->create(['year' => 2026, 'is_active' => true]);
        $field = BudgetField::query()->create(['code' => 1, 'name' => 'Pemerintahan']);
        BudgetActivity::query()->create([
            'budget_year_id' => $year->id,
            'budget_field_id' => $field->id,
            'name' => 'Kegiatan Uji',
            'budget_amount' => 100000,
            'realized_amount' => 75000,
            'status' => 'Sedang Berjalan',
        ]);

        $data = app(BudgetDataService::class)->all();

        $this->assertSame(['Pemerintahan'], array_values($data['bidang']));
        $this->assertSame(2026, (int) array_key_first($data['years']));
        $this->assertSame(['Kegiatan Uji', 1, 100000, 75000, 'Sedang Berjalan'], $data['years'][2026]['activities'][0]);
    }

    public function test_apbdes_and_realisasi_pages_are_available(): void
    {
        BudgetYear::query()->create(['year' => 2026, 'is_active' => true]);

        $this->get('/apbdes')->assertOk();
        $this->get('/realisasi-anggaran')->assertOk();
    }

    public function test_realization_cannot_exceed_budget(): void
    {
        $year = BudgetYear::query()->create(['year' => 2026, 'is_active' => true]);
        $field = BudgetField::query()->create(['code' => 1, 'name' => 'Pemerintahan']);

        $activity = BudgetActivity::query()->create([
            'budget_year_id' => $year->id,
            'budget_field_id' => $field->id,
            'name' => 'Kegiatan',
            'budget_amount' => 100000,
            'realized_amount' => 50000,
            'status' => 'Sedang Berjalan',
        ]);

        $this->assertLessThanOrEqual($activity->budget_amount, $activity->realized_amount);
    }
}
