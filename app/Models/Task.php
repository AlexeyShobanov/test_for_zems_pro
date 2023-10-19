<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "project_id",
        "start_time",
        "finish_time"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "start_time" => "datetime:d.m.Y H:i",
        "finish_time" => "datetime:d.m.Y H:i",
    ];

    public function duration(): Attribute
    {
        return Attribute::make(
            get: fn() => (new Carbon($this->start_time ?: now()))->diffInHours($this->finish_time ?: Carbon::now())
        );
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
