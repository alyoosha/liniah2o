<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Parser\Parser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateCatalogPrices extends Command
{
    protected $url;

    protected $prices_xml;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:update-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update catalog prices, discount prices (optional) and product stock';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url = Storage::disk('public')->url('xml');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!Storage::disk('public')->exists('xml/upload_price.xml')) {
            echo "FILE xml/upload_price.xml not found \n";
            exit;
        } else {
            echo "UPDATE start at:". now()->format('Y-m-d H:i:s') ."\n";

            $file_prices_xml = file_get_contents($this->url.'/upload_price.xml');
            $this->prices_xml = new \SimpleXMLElement($file_prices_xml);

            $productPrices = $this->parseProductsPricesToArray();

            $totalProducts = $limit = count($productPrices);
            $notfound = [];
            $updated = [];

            for($i = 0; $i < $limit; $i++) {
                $p = Product::where('articul', $productPrices[$i]['articul'])->first();

                if($p) {
                    $p->price = $productPrices[$i]['price'];
                    $p->stock = $productPrices[$i]['stock'];
                    if(isset($productPrices[$i]['discount_price'])) {
                        $p->discount_price = $productPrices[$i]['discount_price'];
                    }

                    $p->save();

                    $updated[] = $productPrices[$i]['articul'];
                } else {
                    $notfound[] = $productPrices[$i]['articul'];
                }
            }

            echo "\nUpdated articles: ". implode(',', $updated). "\n";
            echo "\nNot found articles: ". implode(',', $notfound). "\n";
            echo "\nTotal updated: ". $totalProducts. "\n";
        }
    }

    public function parseProductsPricesToArray() :  array
    {
        $productPrices = [];

        $i = 0;

        foreach ($this->prices_xml->products->product as $product) {
            $productPrices[$i] = [
                'articul' => (int)$product->product_id,
                'price' => (float)$product->price,
                'stock' => (int)$product->stock
            ];

            if(isset($product->discount_price)) {
                $productPrices[$i]['discount_price'] = (float)$product->discount_price;
            }

            $i++;
        }

        return $productPrices;
    }
}
