<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {
    protected $fillable = ['content_html','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
