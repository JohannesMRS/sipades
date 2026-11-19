<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\BeritaCategory;
use App\Models\BudgetActivity;
use App\Models\BudgetField;
use App\Models\BudgetYear;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseSevenTest extends TestCase
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

    public function test_public_pages_remain_available_with_empty_data(): void
    {
        $this->get('/')->assertOk();
        $this->get('/berita')->assertOk();
        $this->get('/dokumen-publik')->assertOk();
        $this->get('/informasi-pembangunan')->assertOk();
    }

    public function test_draft_news_is_not_public(): void
    {
        $category = BeritaCategory::query()->create(['name' => 'Berita', 'slug' => 'berita']);
        Berita::factory()->create([
            'berita_category_id' => $category->id,
            'slug' => 'draft-rahasia',
            'status' => 'draft',
        ]);

        $this->get('/berita/draft-rahasia')->assertNotFound();
    }

    public function test_realization_cannot_exceed_budget(): void
    {
        $year = BudgetYear::query()->create(['year' => 2026, 'is_active' => true]);
        $field = BudgetField::query()->create(['code' => 1, 'name' => 'Pemerintahan']);

        $this->expectException(\InvalidArgumentException::class);

        BudgetActivity::query()->create([
            'budget_year_id' => $year->id,
            'budget_field_id' => $field->id,
            'name' => 'Tidak Valid',
            'budget_amount' => 100,
            'realized_amount' => 101,
            'status' => 'Sedang Berjalan',
        ]);
    }

    public function test_operator_cannot_manage_accounts(): void
    {
        $operator = User::factory()->create(['role' => 'operator', 'is_active' => true]);
        $other = User::factory()->create(['role' => 'operator', 'is_active' => true]);
        $policy = new UserPolicy;

        $this->assertFalse($policy->viewAny($operator));
        $this->assertFalse($policy->create($operator));
        $this->assertFalse($policy->update($operator, $other));
    }
}
