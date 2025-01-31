<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marketing extends Model
{
    use HasFactory;
    protected $table = 'marketings';
    protected $fillable = ['name'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
