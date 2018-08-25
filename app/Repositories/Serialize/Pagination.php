<?php

namespace App\Repositories\Serialize;

class Pagination
{
    public static function getResource($resource)
    {
        $dataSource = $resource->toArray();

        return [
          'meta' => [
            'total' => $dataSource['total'],
            'per_page' => $dataSource['per_page'],
            'last_page' => $dataSource['last_page'],
            'current_page' => $dataSource['current_page']
          ],
          'data' => $dataSource['data'],
        ];
    }
}
