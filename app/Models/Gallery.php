<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {
    protected $fillable = ['file_path','caption','span_type','alt_text','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];
    public function imageUrl(): string {
        return $this->file_path ? asset('storage/' . $this->file_path) : '';
    }
}
