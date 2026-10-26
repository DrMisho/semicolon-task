<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'completed', 'user_id'])]
class Task extends Model
{
    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'completed' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
