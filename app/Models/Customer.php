<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable implements FilamentUser
{
    use SoftDeletes;

    protected $guard = 'customer';
    protected $fillable = ['name', 'email', 'password', 'company_id', 'partner_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() == 'customer';
    }
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
