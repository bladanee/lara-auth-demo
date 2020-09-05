<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Admin;
class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
        'added_by',
    ];
    
    public function addedByAdmin()
    {
        return $this->hasOne(Admin::class, 'id', 'added_by');
    }
}
