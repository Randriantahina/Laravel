<?php

namespace App\Models;

use App\Http\Resources\TodoResource;
use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'title', 'description', 'completed'])]
#[UseFactory(TodoFactory::class)]
#[UseResource(TodoResource::class)]
class Todo extends Model
{
  /** @use HasFactory<TodoFactory> */
  use HasFactory;

  protected function casts(): array
  {
    return [
      'completed' => 'boolean',
    ];
  }

  #[Scope]
  protected function completed(Builder $query): void
  {
    $query->where('completed', true);
  }

  #[Scope]
  protected function pending(Builder $query): void
  {
    $query->where('completed', false);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
