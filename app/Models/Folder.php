<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'folder_path',
    ];

    public function subfolder() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function files() {
        return $this->hasMany(File::class);
    }
}
