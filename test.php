<?php
use Illuminate\Support\Str;


class Test
{
  public function generateToken()
  {
    $this->api_token = Str::random(60);

    return $this->api_token;
  }
}

$test = new Test();


$test->generateToken();

