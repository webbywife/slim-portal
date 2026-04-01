<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EnrollmentStep extends Model {
    public $timestamps = false;
    protected $fillable = ['step_title','step_desc','sort_order'];
}
