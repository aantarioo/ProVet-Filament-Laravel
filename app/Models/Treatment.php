<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Treatment extends Model
{
    protected $casts = [
      'price' => MoneyCast::class,
    ];
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
