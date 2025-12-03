<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_category';
    protected $fillable = ['nama_category'];

    // Accessor untuk kompatibilitas
    public function getIdAttribute()
    {
        return $this->id_category;
    }

    public function getNameAttribute()
    {
        return $this->nama_category;
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'id_category', 'id_category');
    }
}
