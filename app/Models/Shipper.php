<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    protected $table = 'shipper';

    protected $fillable = ['shipper_name', 'shipper_contact', 'shipper_address', 'image'];
}
