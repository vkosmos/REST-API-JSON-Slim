<?php

namespace App\Models;

use App\Model;

class Products extends Model
{
    const TABLE = 'products';

    public $title;
    public $description;
    public $price;

}
