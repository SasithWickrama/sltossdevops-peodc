<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iptv_disconnection_feedback extends Model
{
    protected $table = 'Iptv_disconnection_feedback';
    protected $fillable = ['DISCONNECTION_REASON','CP_HANDOVER','REPLY_DATE'];

    public $timestamps = false;
    public $incrementing = false;
    
}
