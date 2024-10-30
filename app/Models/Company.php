<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Company",
 *     type="object",
 *     description="Company Model",
 *     required={"name", "NIP", "address", "city", "postal_code"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the company"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the company"
 *     ),
 *     @OA\Property(
 *         property="NIP",
 *         type="string",
 *         description="NIP of the company"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the company"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City where the company is located"
 *     ),
 *     @OA\Property(
 *         property="postal_code",
 *         type="string",
 *         description="Postal code of the company"
 *     )
 * )
 */

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'NIP',
        'address',
        'city',
        'postal_code'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
