<?php

namespace Modules\Vehicle\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Tanker extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tankers";

    protected static $logName = 'tankers';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['nomor_polisi', 'id'];

    public function inspections()
    {
        return $this->hasMany('Modules\Trip\Entities\Inspection');
    }

    protected static function newFactory()
    {
        return \Modules\Vehicle\Database\factories\TankerFactory::new();
    }
}
