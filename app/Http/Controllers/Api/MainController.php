<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Homepage;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MainController extends Controller
{
    protected const SUCCESS_STATUS_CODE = 200;
    protected const SUCCESS_MESSAGE = 'OK';

    public function getOdds()
    {
        $homepage = Homepage::find(1);
        return json_decode($homepage->odds);
    }

    public function uploadImage(Request $request)
    {
        $uploadedFile = $request->file('file');
        $uploadedPath = 'public/homepage';
        $uploadedFilename = $request->file('file')->getClientOriginalName();

        if($uploadedFile->storeAs($uploadedPath, $uploadedFilename)) {
            return response(self::SUCCESS_MESSAGE, self::SUCCESS_STATUS_CODE);
        }
    }
}
