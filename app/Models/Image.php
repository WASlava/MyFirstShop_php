<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $original_filename
 * @property string $filename
 * @property string $disk
 *
 * @property-read string $src
 */
class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'original_filename',
        'filename',
        'disk',
    ];

    public function getSrcAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->getFullFilename());
    }

    public function getFullFilename(): string {
        $dir1 = $this->filename[0];
        $dir2 = $this->filename[1];
        return $dir1 . '/' . $dir2 . '/' . $this->filename;
    }

    protected static function booted()
    {
        parent::boot();
        Image::deleting(function (Image $image) {
            Storage::disk($image->disk)->delete($image->getFullFilename());
        });
    }
}

