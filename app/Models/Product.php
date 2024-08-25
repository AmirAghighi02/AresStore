<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User, Product>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<FeatureValue>
     */
    public function featureValues(): BelongsToMany
    {
        return $this->belongsToMany(FeatureValue::class, 'products_features_values', 'product_id', 'feature_value_id');
    }

    /**
     * @return BelongsToMany<Order>
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot(['count', 'final_cost']);
    }
}
