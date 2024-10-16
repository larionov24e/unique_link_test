<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static where(string $string, string $hash)
 *
 * @property string hash
 * @property int user_id
 * @property string expiry_at
 * @property bool is_active
 */
class Link extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'hash',
        'user_id',
        'expiry_at',
        'is_active',
    ];
}
