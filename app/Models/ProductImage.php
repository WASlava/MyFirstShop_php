<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $product_id
 * @property string $original_filename
 * @property string $filename
 * @property string $disk
 * @property bool $is_default
 * @property Product $product
 *
 * @property-read string $src
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'original_filename',
        'filename',
        'disk',
        'is_default',  // Поле для відмітки, чи є зображення основним
    ];

    // Відношення "Багато до одного" з продуктом
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Атрибут для отримання URL зображення
    public function getSrcAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->getFullFilename());
    }

    // Отримання повного шляху до файлу з використанням вкладених директорій
    public function getFullFilename(): string
    {
        $dir1 = $this->filename[0] ?? '';
        $dir2 = $this->filename[1] ?? '';
        return $dir1 . '/' . $dir2 . '/' . $this->filename;
    }

    // Автоматичне видалення файлів при видаленні моделі
    protected static function booted()
    {
        parent::boot();

        static::deleting(function (ProductImage $image) {
            Storage::disk($image->disk)->delete($image->getFullFilename());
        });
    }

    // Призначити поточне зображення як "за змовчанням" для продукту
    public static function setDefaultForProduct(int $imageId, int $productId): bool
    {
        $images = self::where('product_id', $productId)->get();

        foreach ($images as $img) {
            $img->is_default = $img->id == $imageId;
            $img->save();
        }

        return true;
    }
}
