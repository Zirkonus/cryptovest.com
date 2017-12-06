<?php

namespace App\Http\Controllers;

use App\Http\Services\TinifyService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    protected $paginationItemPerList = 5;
    protected $tinify;
    const BASE_PATH = 'public/upload/images/';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $currentUser;

    public function __construct(TinifyService $tinifyService)
    {
        $this->currentUser = Auth::user();

        $this->middleware(function ($request, $next) {
            view()->share('currentUser', Auth::user());
            return $next($request);
        });
        $this->tinify = $tinifyService;
    }

    /**
     * Get image information
     *
     * @param $file
     * @param $pathPrefix
     * @param $image
     * @param $model
     * @param $field
     */
    protected function imageOptimization($file, $pathPrefix = false, $image, $model, $field, $name = false)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $directoryPath = self::BASE_PATH . $pathPrefix . "/";
        $fileName = $name ?: $model->id . "." . $fileExtension;
        $path = $pathPrefix ? $pathPrefix . "/" : "";
        if (!Storage::exists($directoryPath)) {
            Storage::makeDirectory($directoryPath, 0775);
        }
        $this->tinify->getFromBuffer((string)$image->encode($fileExtension))
            ->toFile(storage_path('app/' . $directoryPath . "/" . $fileName));
        $model->$field = "storage/upload/images/" . $path . $fileName;
        $model->save();
    }

}
