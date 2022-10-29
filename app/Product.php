<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title = "Product",
 *      description = "Product Model",
 *      schema="Product",
 *      properties={
 *          @OA\Property(property="id", type="integer", format="int64", description="id column"),
 *          @OA\Property(property="name", type="string"),
 *          @OA\Property(property="price", type="double")
 *      } 
 * )
 */


class Product extends Model
{
    #protected $fillable = ['name','slug','price'];
    protected $guarded = [];
}
