<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model {
    protected $fillable = ['course_id','title','prerequisite','sessions','description','tuition_fee','materials_fee','sort_order'];
    protected $casts = ['sessions' => 'integer'];

    public function course() { return $this->belongsTo(Course::class); }
    public function submodules() { return $this->hasMany(CourseSubmodule::class, 'module_id')->orderBy('sort_order'); }
}
