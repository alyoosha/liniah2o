<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Settings
 * @package App
 */
class Settings extends Model
{
    /**
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var array
     */
    protected $fillable = [
        'rate',
        'session',
        'performance',
        'company_name',
        'company_phone',
        'developed_by',
        'site_logo'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
