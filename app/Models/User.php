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
        'google_id',
        'password',
        'phone',
        'address',
        'avatar',
        'gender',
        'birthday',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function getAvatarUrlAttribute()
    {
        if (!empty($this->avatar)) {
            if (\Illuminate\Support\Str::startsWith($this->avatar, ['http://', 'https://'])) {
                return $this->avatar;
            }
            if (file_exists(public_path($this->avatar))) {
                return asset($this->avatar);
            }
            if (file_exists(public_path('fontend/img/' . basename($this->avatar)))) {
                return asset('fontend/img/' . basename($this->avatar));
            }
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?: 'User') . '&background=10b981&color=fff&bold=true';
    }

    public function chatSessions()
    {
        return $this->hasMany(ChatSession::class);
    }

    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favoriteTours()
    {
        return $this->belongsToMany(Tour::class, 'favorites');
    }
    
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'user_vouchers')->withPivot('status', 'used_at')->withTimestamps();
    }
}
