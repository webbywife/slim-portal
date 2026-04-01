<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HeroStat extends Model {
    public $timestamps = false;
    protected $fillable = ['stat_value','stat_label','sort_order'];
}
