<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'severity', 'title', 'description', 'client_id','support_id','level_id','project_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];

    protected $appends = ['severity_full','title_short','support_full','state'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function support()
    {
        return $this->belongsTo(User::class,'support_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
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

    public function getSupportFullAttribute()
    {
        if ($this->support){
            return $this->support->name;
        }        
        return 'Sin asignar';     
    }

    public function getStateAttribute()
    {
        if ($this->support_id && $this->active == 1)
            return 'Asignado';

        if ($this->support_id == null && $this->active == 1)
            return 'Pendiente';
           
        if ($this->active == 0)
            return 'Resuelto';
            
        // return 'Pendiente';     
    }

    public function getTitleShortAttribute()
    {
        return mb_strimwidth($this->title,0,20,'...');
    }
}
