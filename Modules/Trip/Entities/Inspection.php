<?php

namespace Modules\Trip\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Inspection extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "inspections";

    protected static $logName = 'inspections';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['tanker_id', 'day_id', 'id'];

    public function day()
    {
        return $this->belongsTo('Modules\Trip\Entities\Day');
    }

    public function tanker()
    {
        return $this->belongsTo('Modules\Vehicle\Entities\Tanker');
    }

    protected static function newFactory()
    {
        return \Modules\Trip\Database\factories\InspectionFactory::new();
    }
}
