<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model {
    protected $fillable = ['category_tag','course_name','slug','description','duration','card_gradient','course_image','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];

    public function modules() { return $this->hasMany(CourseModule::class)->orderBy('sort_order'); }

    public static function generateSlug(string $name, ?int $exceptId = null): string {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;
        while (
            static::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) { $slug = $original . '-' . $count++; }
        return $slug;
    }
}
