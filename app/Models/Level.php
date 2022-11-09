<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','project_id'
    ];

    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongTo(Project::class);
    }
    
}
