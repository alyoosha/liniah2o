<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Locale;
use App\Http\Middleware\User;
use App\Models\Images;
use Egorovagency\Settings\Http\Middleware\Authorize;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ShortPixel\ShortPixel;
use ShortPixel\Source;

class ImagesParser extends Controller
{
    public function setInvisibleImages(Request $request) {
        $collections = collect(scandir(public_path('storage/collections')));
        $collectionsOptimized = collect(scandir(public_path('storage/compressed_images/collections/images_optimized')));

        $products = collect(scandir(public_path('storage/products')));
        $productsOptimized = collect(scandir(public_path('storage/compressed_images/products/images_optimized')));

        $productsDiff = $productsOptimized
            ->diff($products)
            ->filter(function ($image) {
            preg_match('/^[A-Za-z0-9]+\_[0-9]{2,}\.(?:jpg)$/i', $image, $matches);
            if(!empty($matches)) return $image;
        })
            ->map(function ($image) {
            return explode('.', $image)[0];
        });

        $collectionsDiff = $collectionsOptimized
            ->diff($collections)
            ->filter(function ($image) {
            preg_match('/^[A-Za-z0-9]+\_[0-9]{2,}\.(?:jpg)$/i', $image, $matches);
            if(!empty($matches)) return $image;
        })
            ->map(function ($image) {
            return explode('.', $image)[0];
        });

        $mergeDiff = $productsDiff->merge($collectionsDiff);

        try {
            Images::whereIn('name', $mergeDiff)
                ->update(['is_visible' => 1]);
        }
        catch (QueryException $exception) {
            $exception->getMessage();
        }

    }

    public function parserImages(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $products = Storage::files('public/products');
        $collections = Storage::files('public/collections');
        $pathToStorage = Storage::path('public');
        $date = date('Y-m-d');

        $pdo = DB::connection()->getPdo();
        $sth = $pdo->prepare("SELECT name, size, date_dir, id FROM images");
        $sth->execute();

        $imagesFromTable = $sth->fetchAll(\PDO::FETCH_UNIQUE | \PDO::FETCH_ASSOC);

        $imagesProductInsert = $imagesCollectInsert = $imagesProductOptimizationInsert = $imagesCollectOptimizationInset = [];

        foreach ($products as $k => $p) {
            $images = [];
            $imagesOptimization = [];

            $fullName = array_reverse(explode('/', $p))[0];
            preg_match('/^[A-Za-z0-9]+\_[0-9]{2,}\.(?:jpg|jgep)$/i', $fullName, $matches);

            if(empty($matches)) continue;

            $list = explode('.', $fullName);
            list($name, $ext) = $list;

            $articul = strstr($name, '_', true);
            $size = Storage::size($p);

            if($articul) {
                try {
                    if(!array_key_exists($name, $imagesFromTable)) {
                        $pth = trim('public/compressed_images/products/images_resized/' . $date . '/' . $articul);
                        Storage::makeDirectory($pth);

                        copy($pathToStorage . '/products/' . $name . '.' . $ext,
                            $pathToStorage . '/compressed_images/products/images_optimized/' . $name . '.' . $ext);

                        $images['product_articul'] = $articul;
                        $images['collection_articul'] = null;
                        $images['name'] = $name;
                        $images['ext'] = $ext;
                        $images['size'] = $size;
                        $images['date_dir'] = $date;
                        $images['path'] = Storage::url('compressed_images/products/images_optimized/' . $name . '.' . $ext);

                        $paths[0] = Storage::url('compressed_images/products/images_resized/' . $date . '/' . $articul . '/' . $name . '-355.' . $ext);
                        $paths[1] = Storage::url('compressed_images/products/images_resized/' . $date . '/' . $articul . '/' . $name . '-530.' . $ext);

                        $images['paths_resized'] = implode(',', $paths);

                        $img355 = self::resizeImage355($p);
                        $stream355 = self::convertResource($img355);
                        imagedestroy($img355);
                        Storage::put('/public/compressed_images/products/images_resized/' . $date . '/' . $articul . '/' . $name . '-355.' . $ext, $stream355);

                        $img530 = self::resizeImage530($p);
                        $stream530 = self::convertResource($img530);
                        imagedestroy($img530);
                        Storage::put('/public/compressed_images/products/images_resized/' . $date . '/' . $articul . '/' . $name . '-530.' . $ext, $stream530);

                        $imagesOptimization['image_name'] = $name;
                    }
                    else {
                        if($imagesFromTable[$name]['size'] != $size) {
                            copy($pathToStorage . '/products/' . $name . '.' . $ext,
                                $pathToStorage . '/compressed_images/products/images_optimized/' . $name . '.' . $ext);

                            $image = Images ::where('name', $name)->first();
                            $image->size = $size;
                            $image->save();

                            $img355 = self::resizeImage355($p);
                            $stream355 = self::convertResource($img355);
                            imagedestroy($img355);
                            Storage::put('/public/compressed_images/products/images_resized/' . $imagesFromTable[$name]['date_dir'] . '/' . $articul . '/' . $name . '-355.' . $ext, $stream355);

                            $img530 = self::resizeImage530($p);
                            $stream530 = self::convertResource($img530);
                            imagedestroy($img530);
                            Storage::put('/public/compressed_images/products/images_resized/' . $imagesFromTable[$name]['date_dir'] . '/' . $articul . '/' . $name . '-530.' . $ext, $stream530);

                            $imagesOptimization['image_name'] = $name;
                        }
                    }
                }
                catch (\Exception $e) {}
            }

            if(!empty($images)) {
                $imagesProductInsert[$name] = $images;
            }

            if(!empty($imagesOptimization)) {
                $imagesProductOptimizationInsert[$name] = $imagesOptimization;
            }
        }

        foreach ($collections as $k => $c) {
            $images = [];
            $imagesOptimization = [];

            $fullName = array_reverse(explode('/', $c))[0];
            preg_match('/^[A-Za-z0-9]+\_[0-9]{2,}\.(?:jpg|jgep)$/i', $fullName, $matches);

            if(empty($matches)) continue;

            $list = explode('.', $fullName);
            list($name, $ext) = $list;

            $articul = strstr($name, '_', true);
            $size = Storage::size($c);

            if($articul) {
                try {
                    if (!array_key_exists($name, $imagesFromTable)) {
                        $pth = trim('public/compressed_images/collections/images_resized/' . $date . '/' . $articul);
                        Storage::makeDirectory($pth);

                        copy($pathToStorage . '/collections/' . $name . '.' . $ext,
                            $pathToStorage . '/compressed_images/collections/images_optimized/' . $name . '.' . $ext);

                        $images['product_articul'] = null;
                        $images['collection_articul'] = $articul;
                        $images['name'] = $name;
                        $images['ext'] = $ext;
                        $images['size'] = $size;
                        $images['date_dir'] = $date;
                        $images['path'] = Storage::url('compressed_images/collections/images_optimized/' . $name . '.' . $ext);

                        $paths[0] = Storage::url('compressed_images/collections/images_resized/' . $date . '/' . $articul . '/' . $name . '-535.' . $ext);
                        $paths[1] = Storage::url('compressed_images/collections/images_resized/' . $date . '/' . $articul . '/' . $name . '-710.' . $ext);
                        $images['paths_resized'] = implode(',', $paths);

                        $img535 = self::resizeImage535($c);
                        $stream535 = self::convertResource($img535);
                        imagedestroy($img535);
                        Storage::put('/public/compressed_images/collections/images_resized/' . $date . '/' . $articul . '/' . $name . '-535.' . $ext, $stream535);

                        $img710 = self::resizeImage710($c);
                        $stream710 = self::convertResource($img710);
                        imagedestroy($img710);
                        Storage::put('/public/compressed_images/collections/images_resized/' . $date . '/' . $articul . '/' . $name . '-710.' . $ext, $stream710);

                        $imagesOptimization['image_name'] = $name;
                    } else {
                        if ($imagesFromTable[$name]['size'] != $size) {
                            copy($pathToStorage . '/collections/' . $name . '.' . $ext,
                                $pathToStorage . '/compressed_images/collections/images_optimized/' . $name . '.' . $ext);

                            $image = Images::where('name', $name)->first();
                            $image->size = $size;
                            $image->save();

                            $img535 = self::resizeImage535($c);
                            $stream535 = self::convertResource($img535);
                            imagedestroy($img535);
                            Storage::put('/public/compressed_images/collections/images_resized/' . $imagesFromTable[$name]['date_dir'] . '/' . $articul . '/' . $name . '-535.' . $ext, $stream535);

                            $img710 = self::resizeImage710($c);
                            $stream710 = self::convertResource($img710);
                            imagedestroy($img710);
                            Storage::put('/public/compressed_images/collections/images_resized/' . $imagesFromTable[$name]['date_dir'] . '/' . $articul . '/' . $name . '-710.' . $ext, $stream710);

                            $imagesOptimization['image_name'] = $name;
                        }
                    }
                } catch (\Exception $e) {}
            }

            if(!empty($images)) {
                $imagesCollectInsert[$name] = $images;
            }

            if(!empty($imagesOptimization)) {
                $imagesCollectOptimizationInset[$name] = $imagesOptimization;
            }
        }

        if(!empty($imagesProductInsert) || !empty($imagesCollectInsert)) {
            $arrMerge = array_merge($imagesProductInsert, $imagesCollectInsert);
            foreach (array_chunk($arrMerge, 2000) as $item) {
                Images::insertOnDuplicateKey($item, ['product_articul', 'collection_articul', 'name', 'ext', 'size', 'date_dir', 'path', 'path_resized']);
//                DB::table('images')->insertOrIgnore($item);
            }
        }

        if(!empty($imagesProductOptimizationInsert) || !empty($imagesCollectOptimizationInset)) {
            $arrMerge = array_merge($imagesProductOptimizationInsert, $imagesCollectOptimizationInset);
            foreach (array_chunk($arrMerge, 2000) as $item) {
                DB::table('images_optimization')->insertOrIgnore($item);
            }
        }
    }

    public function imagesOptimization(Request $request) {
        ShortPixel::setKey("2sbE2U5TbMemQoNX9Yb");
        ShortPixel::setOptions(array('base_path' => Storage::path('public')));

        $images = DB::table('images_optimization')
            ->leftJoin('images', 'images.name', '=', 'images_optimization.image_name')
            ->select('images.*')
            ->get();

        $pathToStorage = storage_path('app/public');
        $partRequest = '';
        $ids = [];

        $shortPixel = new Source();

        if(!empty($images)) {
            foreach ($images as $i) {
                if($i->product_articul) {
                    $shortPixel->fromFiles(Storage::path('public/products/' . $i->name . '.' . $i->ext))->optimize(1)->generateWebP()->toFiles('/compressed_images/products/images_optimized/');

                    $img355 = self::resizeImage355( 'public/compressed_images/products/images_optimized/' . $i->name . '.' . $i->ext);
                    $stream355 = self::convertResource($img355);
                    imagedestroy($img355);

                    Storage::put('/public/compressed_images/products/images_resized/' . $i->date_dir . '/' . $i->product_articul . '/' . $i->name . '-355.' . $i->ext, $stream355);

                    $img530 = self::resizeImage530( 'public/compressed_images/products/images_optimized/' . $i->name . '.' . $i->ext);
                    $stream530 = self::convertResource($img530);
                    imagedestroy($img530);

                    Storage::put('/public/compressed_images/products/images_resized/' . $i->date_dir . '/' . $i->product_articul . '/' . $i->name . '-530.' . $i->ext, $stream530);

                    $ids[] = $i->id;
                }
                else {
                    $shortPixel->fromFiles(Storage::path('public/collections/' . $i->name . '.' . $i->ext))->optimize(1)->generateWebP()->toFiles('/compressed_images/collections/images_optimized/' . $i->name . '.' . $i->ext);
//
                    $img535 = self::resizeImage535( 'public/compressed_images/collections/images_optimized/' . $i->name . '.' . $i->ext);
                    $stream535 = self::convertResource($img535);
                    imagedestroy($img535);

                    Storage::put('/public/compressed_images/collections/images_resized/' . $i->date_dir . '/' . $i->collection_articul . '/' . $i->name . '-535.' . $i->ext, $stream535);

                    $img710 = self::resizeImage710( 'public/compressed_images/collections/images_optimized/' . $i->name . '.' . $i->ext);
                    $stream710 = self::convertResource($img710);
                    imagedestroy($img710);

                    Storage::put('/public/compressed_images/collections/images_resized/' . $i->date_dir . '/' . $i->collection_articul . '/' . $i->name . '-710.' . $i->ext, $stream710);

                    $ids[] = $i->id;
                }

                sleep(2);
            };

            DB::table('images_optimization')->truncate();
        }
    }

    protected static function resizeImage530($image) {
        $width530 = 530;
        $height530 = 530;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width530/$height530 > $ratio_orig) {
            $width530 = $height530*$ratio_orig;
        } else {
            $height530 = $width530/$ratio_orig;
        }


        $image_p530 = imagecreatetruecolor($width530, $height530);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p530, $image, 0, 0, 0, 0, $width530, $height530, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p530;

    }

    protected static function resizeImage355($image) {
        $width355 = 355;
        $height355 = 355;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width355/$height355 > $ratio_orig) {
            $width355 = $height355*$ratio_orig;
        } else {
            $height355 = $width355/$ratio_orig;
        }

        $image_p355 = imagecreatetruecolor($width355, $height355);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p355, $image, 0, 0, 0, 0, $width355, $height355, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p355;
    }

    protected static function resizeImage710($image) {
        $width710 = 710;
        $height710 = 710;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width710/$height710 > $ratio_orig) {
            $width710 = $height710*$ratio_orig;
        } else {
            $height710 = $width710/$ratio_orig;
        }

        $image_p710 = imagecreatetruecolor($width710, $height710);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p710, $image, 0, 0, 0, 0, $width710, $height710, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p710;
    }

    protected static function resizeImage535($image) {
        $width535= 535;
        $height535 = 535;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width535/$height535 > $ratio_orig) {
            $width535 = $height535*$ratio_orig;
        } else {
            $height535 = $width535/$ratio_orig;
        }

        $image_p535 = imagecreatetruecolor($width535, $height535);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p535, $image, 0, 0, 0, 0, $width535, $height535, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p535;
    }

    protected static function convertResource($image) {
        ob_start();
        imagejpeg($image, null, 90);
        $binary = ob_get_clean();
        $string = $binary;

        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);
        return $stream;
    }
}
