<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AlumniChip extends Model {
    public $timestamps = false;
    protected $fillable = ['label','sort_order'];
}
