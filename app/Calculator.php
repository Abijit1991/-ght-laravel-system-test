<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Calculator extends Model
{
    //
    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function add() {
        return $this->a + $this->b;
    }

    public function sub() {
        return $this->a - $this->b;
    }

    public function div() {
        return $this->a / $this->b;
    }

    public function mul() {
        return $this->a * $this->b;
    }
}
