<?php

namespace App\Console\Commands;

use App\Models\Feature;
use App\Parser\Parser;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:import-catalog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products, categories, brands, tags and features';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $parser = new Parser;

        $start = microtime(true);
        echo "/////////////\n////////////\nParser start at:". now()->format('Y-m-d H:i:s') ."\n";

        //import tags
        if(!Storage::disk('public')->exists('xml/upload_tags.xml')) {
            echo "FILE xml/upload_tags.xml not found \n";
            exit;
        } else {
            $countOfTags = $parser->parseTags();

            try {
                $parser->insertTags();
            } catch(QueryException $e){
                echo $e->getMessage()." ERROR\n\n";
            }

            echo 'count of parsed tags: '. $countOfTags. "\n";
        }

        //import brands
        if(!Storage::disk('public')->exists('xml/upload_brands.xml')) {
            echo "FILE xml/upload_brands.xml not found \n";
            exit;
        } else {
            $parser->parseBrandCountries();
            $countOfBrands = $parser->parseBrands();

            try {
                $parser->insertBrandCountries();
                $parser->insertBrands();
            } catch(QueryException $e){
                echo $e->getMessage()." ERROR\n\n";
            }

            echo 'count of parsed brands: '. $countOfBrands. "\n";
        }

        // import features
        if(!Storage::disk('public')->exists('xml/upload_features.xml')) {
            echo "FILE xml/upload_features.xml not found \n";
            exit;
        } else {
            $parser->parseFeatureTypes();
            $countOfFeatures = $parser->parseFeatures();

            try {
                $parser->insertFeatureTypes();
                $parser->insertFeatures();
            } catch(QueryException $e){
                echo $e->getMessage()." ERROR\n\n";
            }

            echo 'count of parsed features: '. $countOfFeatures. "\n";
        }

        // import categories and products
        if(!Storage::disk('public')->exists('xml/upload_products.xml')) {
            echo "FILE xml/upload_products.xml not found \n";
            exit;
        } else {
            $countOfCategories = $parser->parseCategories();

            try {
                $parser->updateOrInsertCategories();
            } catch(QueryException $e){
                echo $e->getMessage()." ERROR\n\n";
            }

            echo 'count of parsed categories: '. $countOfCategories. "\n";

            $countOfProducts = $parser->parseProducts();

            try {
                $parser->insertOrUpdateProducts();
            } catch(QueryException $e){
                $parser->dropTmpProducts();
                echo $e->getMessage()." ERROR\n\n";
            }

            echo 'count of parsed products: '. $countOfProducts. "\n";

            $countOfCollections = $parser->parseCollections();

            try {
                $parser->insertOrUpdateCollections();
            } catch(QueryException $e){
                $parser->dropTmpCollections();
                echo $e->getMessage()." ERROR\n\n";
            }

            echo 'count of parsed collections: '. $countOfCollections. "\n";
        }

        $end = microtime(true);
        $timeOfExecution = $end - $start;
        echo "\nExecution time: ". $timeOfExecution . " sec \n\n\n";
    }
}
