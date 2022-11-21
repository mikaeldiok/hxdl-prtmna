<?php

namespace Modules\Trip\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Day extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "days";

    protected static $logName = 'days';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['tanker_id', 'day_id', 'id'];

    public function inspections()
    {
        return $this->hasMany('Modules\Trip\Entities\Inspection');
    }

    protected static function newFactory()
    {
        return \Modules\Trip\Database\factories\DayFactory::new();
    }
}
