<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EnrollmentRequirement extends Model {
    public $timestamps = false;
    protected $fillable = ['requirement','sort_order'];
}
