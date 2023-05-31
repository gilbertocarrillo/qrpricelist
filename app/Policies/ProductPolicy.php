<?php

namespace App\Policies;

use App\Models\Pricelist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Pricelist $pricelist): bool
    {
        return $user->id === $pricelist->user_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Pricelist $pricelist): bool
    {
        return $user->id === $pricelist->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->pricelist->categories()
            ->whereHas('products', function ($query) use ($product) {
                $query->where('id', $product->id);
            })
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->pricelist->categories()
            ->whereHas('products', function ($query) use ($product) {
                $query->where('id', $product->id);
            })
            ->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        //
    }
}
