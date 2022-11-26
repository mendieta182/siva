<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'project_id', 'level_id'
    ];

    protected $table = 'project_user';
    
    /**
     * Get the project that owns the ProjectUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the level that owns the ProjectUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
