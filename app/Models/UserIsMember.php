<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Student;
use App\Models\Classe;
use App\Models\Membership;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserIsMember extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    public $table = 'ismember';

    protected $appends = [
        'files',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'expiration',
        'classe_id',
        'membership_id',
        'student_id',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }


    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function getFilesAttribute()
    {
        return $this->getMedia('files');
    }
}
