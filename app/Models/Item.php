<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'item_id';
    public $table = "item";

    protected $guarded = ['item_id'];
    protected $fillable = ['description','cost_price','sell_price','title','imagePath'];

}
