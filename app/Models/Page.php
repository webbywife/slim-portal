<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model {
    protected $fillable = ['title','slug','excerpt','content','hero_image','meta_description','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];

    public static function generateSlug(string $title, ?int $exceptId = null): string {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;
        while (
            static::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }
        return $slug;
    }
}
