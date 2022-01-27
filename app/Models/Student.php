<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Agegroup;
use App\Models\Langue;

class Student extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes, InteractsWithMedia;

    public $table = 'students';

    protected $appends = [
        'files',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'last_name',
        'first_name',
        'username',
        'age',
        'user_id',
        'classe_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
    protected $hidden = [
        'remember_token',
        'password',
    ];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function age()
    {
        return $this->belongsTo(Agegroup::class, 'age');
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class, 'langue_id');
    }

    public function getFilesAttribute()
    {
        return $this->getMedia('files');
    }
}
