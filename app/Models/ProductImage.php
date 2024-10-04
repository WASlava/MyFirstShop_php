<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $original_filename
 * @property string $filename
 * @property string $disk
 * @property boolean $is_default
 * @property int $product_id
 * @property Product $product
 *
 * @property-read string $src
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'original_filename',
        'filename',
        'disk',
        'is_default',
        'product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getSrcAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->getFullFilename());
    }

    public function getFullFilename(): string
    {
        $dir1 = $this->filename[0];
        $dir2 = $this->filename[1];
        return $dir1 . '/' . $dir2 . '/' . $this->filename;
    }

    protected static function booted()
    {
        parent::boot();
        ProductImage::deleting(function (ProductImage $image) {
            Storage::disk($image->disk)->delete($image->getFullFilename());
        });
    }
}

