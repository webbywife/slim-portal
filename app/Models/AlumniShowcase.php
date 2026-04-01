<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AlumniShowcase extends Model {
    public $timestamps = false;
    protected $fillable = ['alumni_name','alumni_role','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
