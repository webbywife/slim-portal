<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CourseSubmodule extends Model {
    protected $fillable = ['module_id','title','description','sort_order'];
    public function module() { return $this->belongsTo(CourseModule::class); }
}
