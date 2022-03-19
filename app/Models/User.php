<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'options' => 'json',
    ];

    /**
     * Password mutator
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        if (mb_strlen($value) >= 6 && mb_strlen($value) <= 100) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * Language option accessor
     *
     * @return string|NULL
     */
    public function getLanguageOptionAttribute()
    {
        return $this->options['language'] ?? null;
    }

    /**
     * Language option mutator
     *
     * @param string|NULL $value
     */
    public function setLanguageOptionAttribute(string $value = null)
    {
        $options = $this->options;
        $options['language'] = $value;
        $this->options = $options;
    }

    /**
     * Timezone option accessor
     *
     * @return string|NULL
     */
    public function getTimezoneOptionAttribute()
    {
        return $this->options['timezone'] ?? null;
    }

    /**
     * Timezone option mutator
     *
     * @param string|NULL $value
     */
    public function setTimezoneOptionAttribute(string $value = null)
    {
        $options = $this->options;
        $options['timezone'] = $value;
        $this->options = $options;
    }

}
