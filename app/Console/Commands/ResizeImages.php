<?php

namespace App\Console\Commands;

use App\Traits\ResizeImagesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;

class ResizeImages extends Command
{
    use ResizeImagesTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:resize-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy, resize images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
                        $images['is_visible'] = 1;
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
                            $image->is_visible = 1;
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
                        $images['is_visible'] = 1;
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
                            $image->is_visible = 1;
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
                Images::insertOnDuplicateKey($item, ['product_articul', 'collection_articul', 'name', 'ext', 'size', 'date_dir', 'path', 'paths_resized', 'is_visible']);
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
}
