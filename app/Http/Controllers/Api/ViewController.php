<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ViewResource;
use App\Models\View;
use App\Traits\ApiResponse;

class ViewController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $views = View::all();
        return $this->success(ViewResource::collection($views));
    }

    public function show(View $view)
    {
        return $this->success(new ViewResource($view));
    }

    public function destroy(View $view)
    {
        $view->delete();
        return $this->success(null, 'View deleted', 204);
    }
}
