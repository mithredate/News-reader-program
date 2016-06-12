<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Glide\Responses\LaravelResponseFactory;
use App\Http\Requests;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Signatures\SignatureFactory;

class ImageController extends Controller
{
    public function output(Request $request, $path)
    {
        $server = ServerFactory::create([
            'source' => app('filesystem')->disk('gallery')->getDriver(),
            'cache' => app('filesystem')->disk('gallery')->getDriver()->getAdapter()->getPathPrefix().PATH_SEPARATOR.'cache',
            'response' => new LaravelResponseFactory()
        ]);
        return $server->getImageResponse($path, $request->all());
    }
}
