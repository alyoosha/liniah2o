<?php

namespace App\Console\Commands;

use App\Traits\ResizeImagesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ShortPixel\ShortPixel;
use ShortPixel\Source;

class OptimizationImages extends Command
{
    use ResizeImagesTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimization-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimization images via ShortPixel';

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

//        ShortPixel::setKey("i2sbE2U5TbMemQoNX9Yb");
        // ShortPixel::setOptions(array('base_path' => Storage::path('public')));

        $images = DB::table('images_optimization')
            ->leftJoin('images', 'images.name', '=', 'images_optimization.image_name')
            ->select('images.*')
            ->limit(500)
            ->get();

        $ids = [];

        $shortPixel = new Source();

        if(!$images->isEmpty()) {
            foreach ($images as $k => $i) {
                if($i->product_articul) {
                    try {
                        $shortPixel->fromFiles(Storage::path('public/products/' . $i->name . '.' . $i->ext))->optimize(1)->generateWebP()->toFiles(Storage::path('public') . '/compressed_images/products/images_optimized/');

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
                    catch (\Exception $e) {}
                }
                else {
                    try {
                        $shortPixel->fromFiles(Storage::path('public/collections/' . $i->name . '.' . $i->ext))->optimize(1)->generateWebP()->toFiles(Storage::path('public') . '/compressed_images/collections/images_optimized/');

                        $img535 = self::resizeImage535( 'public/compressed_images/collections/images_optimized/' . $i->name . '.' . $i->ext);
                        $stream535 = self::convertResource($img535);
                        imagedestroy($img535);

                        Storage::put('/public/compressed_images/collections/images_resized/' . $i->date_dir . '/' . $i->collection_articul . '/' . $i->name . '-535.' . $i->ext, $stream535);

                        $img710 = self::resizeImage710( 'public/compressed_images/collections/images_optimized/' . $i->name . '.' . $i->ext);
                        $stream710 = self::convertResource($img710);
                        imagedestroy($img710);

                        Storage::put('/public/compressed_images/collections/images_resized/' . $i->date_dir . '/' . $i->collection_articul . '/' . $i->name . '-710.' . $i->ext, $stream710);

                        $ids[] = $i->id;
                    } catch (\Exception $e) {}
                }

                sleep(1);
            };

            DB::table('images_optimization')->whereIn('id', $ids)->delete();
        }
    }
}
