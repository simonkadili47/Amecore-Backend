<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_name',
        'project_description',
        'duration',
        'status',
    ];

    public function officeExpenses()
    {
        return $this->hasMany(OfficeExpense::class, 'project_id', 'project_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'project_id', 'project_id');
    }
}
