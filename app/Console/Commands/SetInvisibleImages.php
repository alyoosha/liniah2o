<?php

namespace App\Console\Commands;

use App\Models\Images;
use Illuminate\Console\Command;

class setInvisibleImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:set-invisible-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set invisible images';

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

        $collections = collect(scandir(public_path('storage/collections')));
        $collectionsOptimized = collect(scandir(public_path('storage/compressed_images/collections/images_optimized')));

        $products = collect(scandir(public_path('storage/products')));
        $productsOptimized = collect(scandir(public_path('storage/compressed_images/products/images_optimized')));

        $productsDiff = $productsOptimized
            ->diff($products)
            ->filter(function ($image) {
                preg_match('/^[A-Za-z0-9]+\_[0-9]{2,}\.(?:jpg)$/i', $image, $matches);
                if(!empty($matches)) return explode('.', $image)[0];
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
                ->update(['is_visible' => 0]);
        }
        catch (QueryException $exception) {
            $exception->getMessage();
        }
    }
}
