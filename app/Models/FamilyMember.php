<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'relationship',
        'religion',
        'education',
        'occupation',
        'marital_status',
        'nationality',
        'father_name',
        'mother_name',
        'notes',
        'is_active',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'supporting_document'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'approved_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('d F Y') : null;
    }

    public function getGenderLabelAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getRelationshipLabelAttribute()
    {
        $labels = [
            'kepala_keluarga' => 'Kepala Keluarga',
            'istri' => 'Istri',
            'suami' => 'Suami',
            'anak' => 'Anak',
            'menantu' => 'Menantu',
            'cucu' => 'Cucu',
            'orangtua' => 'Orang Tua',
            'mertua' => 'Mertua',
            'famili_lain' => 'Famili Lain',
            'pembantu' => 'Pembantu',
            'lainnya' => 'Lainnya'
        ];

        return $labels[$this->relationship] ?? $this->relationship;
    }

    public function getReligionLabelAttribute()
    {
        $labels = [
            'islam' => 'Islam',
            'kristen' => 'Kristen',
            'katolik' => 'Katolik',
            'hindu' => 'Hindu',
            'buddha' => 'Buddha',
            'khonghucu' => 'Khonghucu',
            'lainnya' => 'Lainnya'
        ];

        return $labels[$this->religion] ?? $this->religion;
    }

    public function getEducationLabelAttribute()
    {
        $labels = [
            'tidak_sekolah' => 'Tidak Sekolah',
            'belum_sekolah' => 'Belum Sekolah',
            'tidak_tamat_sd' => 'Tidak Tamat SD',
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'diploma_i' => 'Diploma I',
            'diploma_ii' => 'Diploma II',
            'diploma_iii' => 'Diploma III',
            'diploma_iv' => 'Diploma IV',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3'
        ];

        return $labels[$this->education] ?? $this->education;
    }

    public function getMaritalStatusLabelAttribute()
    {
        $labels = [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati'
        ];

        return $labels[$this->marital_status] ?? $this->marital_status;
    }

    public function getApprovalStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak'
        ];

        return $labels[$this->approval_status] ?? $this->approval_status;
    }

    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800'
        ];

        return $colors[$this->approval_status] ?? 'bg-gray-100 text-gray-800';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }

    public function scopeByRelationship($query, $relationship)
    {
        return $query->where('relationship', $relationship);
    }

    // Helper methods
    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isRejected()
    {
        return $this->approval_status === 'rejected';
    }

    public function canBeUsedForLetters()
    {
        return $this->is_active && $this->isApproved();
    }

    // Static methods
    public static function getRelationshipOptions()
    {
        return [
            'kepala_keluarga' => 'Kepala Keluarga',
            'istri' => 'Istri',
            'suami' => 'Suami',
            'anak' => 'Anak',
            'menantu' => 'Menantu',
            'cucu' => 'Cucu',
            'orangtua' => 'Orang Tua',
            'mertua' => 'Mertua',
            'famili_lain' => 'Famili Lain',
            'pembantu' => 'Pembantu',
            'lainnya' => 'Lainnya'
        ];
    }

    public static function getReligionOptions()
    {
        return [
            'islam' => 'Islam',
            'kristen' => 'Kristen',
            'katolik' => 'Katolik',
            'hindu' => 'Hindu',
            'buddha' => 'Buddha',
            'khonghucu' => 'Khonghucu',
            'lainnya' => 'Lainnya'
        ];
    }

    public static function getEducationOptions()
    {
        return [
            'tidak_sekolah' => 'Tidak Sekolah',
            'belum_sekolah' => 'Belum Sekolah',
            'tidak_tamat_sd' => 'Tidak Tamat SD',
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'diploma_i' => 'Diploma I',
            'diploma_ii' => 'Diploma II',
            'diploma_iii' => 'Diploma III',
            'diploma_iv' => 'Diploma IV',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3'
        ];
    }

    public static function getMaritalStatusOptions()
    {
        return [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati'
        ];
    }
}
