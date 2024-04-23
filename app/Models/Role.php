<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'company_id',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        if (auth()->user()) {

            static::addGlobalScope('company_id', function (Builder $builder) {
                if ( auth()->user() ) {
                    $builder->where('company_id', '=', auth()->user()->company_id);
                }
            });
        }
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
