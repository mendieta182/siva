<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'severity', 'title', 'description', 'client_id','support_id','level_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];

    protected $appends = ['severity_full','title_short'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSeverityFullAttribute()
    {
        switch ($this->severity)
        {
            case 'B':
                return 'Baja';
            case 'N':
                return 'Normal';
            default:
                return 'Alta';
        }
    }

    public function getTitleShortAttribute()
    {
        return mb_strimwidth($this->title,0,20,'...');
    }
}
