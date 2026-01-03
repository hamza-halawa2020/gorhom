<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;

class ReviewController extends BaseController
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('index','show','update','destroy');
        $this->middleware('limitReq');
    }

    public function index()
    {
        $reviews = Review::with('product')->get();
        return $this->success(ReviewResource::collection($reviews));
    }

    public function getAcceptedReviews()
    {
        $reviews = Review::where('status', 'approved')->with('product')->get();
        return $this->success(ReviewResource::collection($reviews));
    }

    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $review = Review::create($data);

        return $this->success(new ReviewResource($review), 'Review created', 201);
    }

    public function show(Review $review)
    {
        $review->load('product');
        return $this->success(new ReviewResource($review));
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        $data = $request->validated();
        $review->update($data);

        return $this->success(new ReviewResource($review), 'Review updated');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return $this->success(null, 'Review deleted', 204);
    }
}
