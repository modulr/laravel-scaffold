<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Transaction extends Model
{
    use Userstamps;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function companyImport()
    {
        return $this->belongsTo('App\Models\Companies\Company', 'company_import_id');
    }

    public function companyExport()
    {
        return $this->belongsTo('App\Models\Companies\Company', 'company_export_id');
    }

    public function customsImport()
    {
        return $this->belongsTo('App\Models\Companies\Company', 'customs_import_id');
    }

    public function customsExport()
    {
        return $this->belongsTo('App\Models\Companies\Company', 'customs_export_id');
    }

    public function finishedByUser()
    {
        return $this->belongsTo('App\User', 'finished_by');
    }

    public function stages()
    {
        return $this->hasMany('App\Models\Stages\Stage'::class);
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
