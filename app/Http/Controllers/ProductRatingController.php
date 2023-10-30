<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RatingResource;
use App\Http\Requests\ProductRatingRequest;
use App\Product;
use App\Rating;
use App\User;
use Illuminate\Support\Facades\Gate;

class ProductRatingController extends Controller
{
    public function rate(Product $product, ProductRatingRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->rate($product, $request->get('score'));
        logger()->info('product' . $product);

        return new ProductResource($product);
    }

    public function unrate(Product $product, Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->unrate($product);

        return new ProductResource($product);
    }

    public function approve(Rating $rating)
    {

        Gate::authorize("admin", $rating);

        $rating->approve();
        $rating->save();

        return response()->json();
    }

    public function list(Request $request)
    {

        Gate::authorize("admin");

        $builder = Rating::query();

        if ($request->has("approved"))
            $builder->whereNotNull("approved_at");

        if ($request->has("notApproved"))
            $builder->whereNull("approved_at");

        return RatingResource::collection($builder->get());
    }
}
