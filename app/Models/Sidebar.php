<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'icon', 'parent_id', 'order', 'is_active','admin_access_only'];

    // Relationship for parent-child hierarchy
    public function children()
    {
        return $this->hasMany(Sidebar::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Sidebar::class, 'parent_id');
    }
}
