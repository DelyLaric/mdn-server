<?php

namespace App\Repositories\Models;

class Area extends BaseModel
{
  protected $table = 'public.areas';

  protected $casts = [
    'column_ids' => 'array'
  ];
}
