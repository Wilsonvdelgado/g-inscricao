<?php

namespace App\Models\Helper;

class OrderItem
{
    public $type, $title, $key;

    public function __construct($key, $title, $type)
    {
        $this->key = $key;
        $this->type = $type;
        $this->title = $title;
    }
}
