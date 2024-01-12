<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'cedula',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    public static $rules = [
        'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public static function createproducer(array $data){
      return self::create(
        [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'produccion',
            'password' => Hash::make($data['password']),
        ]
      );
    }

      public function producers (){
        return $this->belongsToMany(producers::class)->withTimestamps();
      }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function scopeProducciones($query){
        return $query->where('role','produccion');
    }
    public function scopeConductores($query){
        return $query->where('role','conductor');
    }
    public function asDriverAppointments(){
        return $this->hasMany(Appointment::class, 'conductor_id');
    }
    public function asProductionsAppointments(){
        return $this->hasMany(Appointment::class, 'production_id');
    }
    public function attendedAppointments (){
        return $this->asDriverAppointments()->where('status','Completada');
    }
    public function cancelledAppointments (){
        return $this->asDriverAppointments()->where('status','Cancelada');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function sendFCM($message){
       return fcm()
        ->to([
            $this->device_token
        ]) 
        ->priority('high')
        ->timeToLive(0)
        ->notification([
            'title' => config('app.name'),
            'body' => $message,
        ])
        ->send();

    }
}
