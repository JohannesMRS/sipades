<?php

namespace Tests\Feature;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $other = User::factory()->create(['role' => 'operator', 'is_active' => true]);
        $policy = new UserPolicy;

        $this->assertTrue($policy->viewAny($admin));
        $this->assertTrue($policy->create($admin));
        $this->assertTrue($policy->update($admin, $other));
        $this->assertTrue($policy->delete($admin, $other));
    }

    public function test_operator_cannot_manage_accounts_but_can_update_self(): void
    {
        $operator = User::factory()->create(['role' => 'operator', 'is_active' => true]);
        $other = User::factory()->create(['role' => 'operator', 'is_active' => true]);
        $policy = new UserPolicy;

        $this->assertFalse($policy->viewAny($operator));
        $this->assertFalse($policy->create($operator));
        $this->assertTrue($policy->update($operator, $operator));
        $this->assertFalse($policy->update($operator, $other));
        $this->assertFalse($policy->delete($operator, $other));
    }

    public function test_inactive_user_cannot_access_panel(): void
    {
        $inactive = User::factory()->create(['role' => 'operator', 'is_active' => false]);

        $this->assertFalse($inactive->canAccessPanel(app('filament')->getCurrentOrDefaultPanel()));
    }

    public function test_admin_and_operator_can_access_active_panel(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $operator = User::factory()->create(['role' => 'operator', 'is_active' => true]);
        $panel = app('filament')->getCurrentOrDefaultPanel();

        $this->assertTrue($admin->canAccessPanel($panel));
        $this->assertTrue($operator->canAccessPanel($panel));
    }

    public function test_public_home_page_still_returns_success(): void
    {
        $this->get('/')->assertOk();
    }
}
