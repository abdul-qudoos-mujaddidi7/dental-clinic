<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable 
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public const COLUMN_PROFILE_PICTURE = 'profile_picture';
    public const COLUMN_FIRST_NAME = 'first_name';
    public const COLUMN_LAST_NAME = 'last_name';
    public const COLUMN_PHONE = 'phone';
    public const COLUMN_EMAIL = 'email';
    public const COLUMN_STATUS = 'status';
    public const COLUMN_PASSWORD = 'password';


    public $images = [ 
        self::COLUMN_PROFILE_PICTURE
    ];


    public function scopeSearch($query, $search){

        if(!$search){
            return $query;
        }
        return $query->where("name","LIKE","%". $search ."%");
    }

    public function billExpenses()
    {
        return $this->hasMany(BillExpense::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_EMAIL,
        self::COLUMN_FIRST_NAME,
        self::COLUMN_LAST_NAME,
        self::COLUMN_PHONE,
        self::COLUMN_STATUS,
        self::COLUMN_PROFILE_PICTURE,
        self::COLUMN_PASSWORD
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
