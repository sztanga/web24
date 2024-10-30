<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Employee",
 *     required={"first_name", "last_name", "email", "company_id"},
 *     @OA\Property(
 *          property="id",
 *          type="integer", example=1
 *     ),
 *     @OA\Property(
 *          property="first_name",
 *          type="string",
 *          example="John"
 *     ),
 *     @OA\Property(
 *          property="last_name",
 *          type="string",
 *          example="Doe"
 *     ),
 *     @OA\Property(
 *          property="email",
 *          type="string",
 *          example="john.doe@example.com"
 *     ),
 *     @OA\Property(
 *          property="phone",
 *          type="string",
 *          example="123-456-7890"
 *     ),
 *     @OA\Property(
 *          property="company_id",
 *          type="integer",
 *          example=1,
 *          description="Company associated with the employee"
 *     ),
 *     @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          example="2024-10-30T12:34:56Z"
 *     ),
 *     @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          example="2024-10-30T12:34:56Z"
 *     ),
 * )
 */

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
