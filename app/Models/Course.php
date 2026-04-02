<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    protected $fillable = ['category_tag','course_name','description','duration','card_gradient','course_image','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];
}
