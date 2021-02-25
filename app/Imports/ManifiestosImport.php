<?php

namespace App\Imports;

use App\ManifiestoContenedor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;

class ManifiestosImport implements ToModel, WithChunkReading
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        return new ManifiestoContenedor([
            'linea'     => $row[0],
            'buque'    => $row[1],
            'viaje'     => $row[2],
            'bl'     => $row[3],
            'procedencia'    => $row[4],
            'comodity'     => $row[5],
            'peso'    => $row[6],
            'numero'     => $row[7],
            'tamano'    => $row[8],
            'tipo'    => $row[9]
        ]);
    }

    public function chunkSize(): int
    {
        return 200;
    }
}