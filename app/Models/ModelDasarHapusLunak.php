<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

abstract class ModelDasarHapusLunak extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';
}
