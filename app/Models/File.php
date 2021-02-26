<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Folder;

class File extends Model
{
    use HasFactory, HasTags;

    protected $fillable = ['name', 'mime_type', 'file_path', 'file_size', 'thumbnail', 'thumbnail_path'];

    public function folder() {
        return $this->belongsTo(Folder::class);
    }
}