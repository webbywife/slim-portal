<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OnlineFeature extends Model {
    public $timestamps = false;
    protected $fillable = ['feature_title','feature_sub','sort_order'];
}
