<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Employee extends Model implements AuthenticatableContract
{
    use HasFactory;
    use AuthenticatableTrait;

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_employment' => 'datetime:d.m.Y',
    ];

    public function getDateOfEmploymentAttribute($value)
    {
        return Carbon::createFromFormat('d.m.Y', $value);
    }

    public function setDateOfEmploymentAttribute($value)
    {
        $this->attributes['date_of_employment'] = Carbon::parse($value)->format('d.m.Y');
    }
}
