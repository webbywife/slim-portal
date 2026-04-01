<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model {
    protected $fillable = ['first_name','last_name','email','inquiry_type','message','is_read','ip_address'];
    protected $casts = ['is_read' => 'boolean'];
    public function getFullNameAttribute(): string { return $this->first_name . ' ' . $this->last_name; }
}
