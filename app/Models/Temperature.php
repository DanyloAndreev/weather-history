<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;

    protected $table = 'temperature';

    protected $attributes = [
        'region_id' => 1,
    ];

    protected $guarded = ['id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
