<?php


namespace App\Http\Controllers\Api;


use App\Models\Settings;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class Parser
{
    public function parseCatalog(Request $request)
    {
        try {
            $currentState = $request->request->all();

            $parser = new \App\Parser\Parser();

            if($currentState['categories']['status'] === 'false') {
                $currentState['categories']['count'] = $parser->parseCategories();

                try {
                    $parser->updateOrInsertCategories();
                } catch(QueryException $e){
                    abort($e->getMessage());
                }

                $currentState['categories']['status'] = 'true';
                return $currentState;
            }

            if($currentState['features']['status'] === 'false') {
                $parser->parseFeatureTypes();
                $currentState['features']['count'] = $parser->parseFeatures();

                try {
                    $parser->insertFeatureTypes();
                    $parser->insertFeatures();
                } catch(QueryException $e){
                    abort($e->getMessage());
                }

                $currentState['features']['status'] = 'true';
                return $currentState;
            }

            if($currentState['brands']['status'] === 'false') {
                $parser->parseBrandCountries();
                $currentState['brands']['count'] = $parser->parseBrands();

                try {
                    $parser->insertBrandCountries();
                    $parser->insertBrands();
                } catch(QueryException $e){
                    abort($e->getMessage());
                }

                $currentState['brands']['status'] = 'true';
                return $currentState;
            }

            if($currentState['tags']['status'] === 'false') {
                $currentState['tags']['count'] = $parser->parseTags();

                try {
                    $parser->insertTags();
                } catch(QueryException $e){
                    abort($e->getMessage());
                }

                $currentState['tags']['status'] = 'true';
                return $currentState;
            }

            if($currentState['products']['status'] === 'false') {
                $currentState['products']['count'] = $parser->parseProducts();

                try {
                    $parser->insertOrUpdateProducts();
                } catch(QueryException $e){
                    $parser->dropTmpProducts();
                    abort($e->getMessage());
                }

                $currentState['products']['status'] = 'true';
                return $currentState;
            }

            if($currentState['collections']['status'] === 'false') {
                $currentState['collections']['count'] = $parser->parseCollections();

                try {
                    $parser->insertOrUpdateCollections();
                } catch(QueryException $e){
                    $parser->dropTmpCollections();
                    abort($e->getMessage());
                }

                $currentState['collections']['status'] = 'true';
                return $currentState;
            }

            return $currentState;
        } catch (\Illuminate\Http\Client\RequestException $exception) {
            abort($exception->getMessage());
        } catch (Exception $exception) {
            abort("В ходе парсинга была получена ошибка: <br>".$exception->getMessage());
        }
    }

    public function updateCatalogImportTimestamps()
    {
        $settings = Settings::find(1);

        if($settings) {
            $settings->catalog_last_updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $settings->save();
        }
        return Carbon::now()->isoFormat('LLL');
    }

    public function getCatalogLastUpdatedAtTimestamps()
    {
        return Carbon::make(get_setting_by_key('catalog_last_updated_at'))->isoFormat('LLL');
    }

    public function compareValidationAndUpdatingCatalogDates()
    {
        $settings = Settings::find(1);

        if($settings) {
            if(Carbon::make($settings->xml_last_validated_at)->greaterThan(Carbon::make($settings->catalog_last_updated_at))) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function updatePrices(Request $request)
    {
        $step = $request->step;
        $totalSteps = $request->steps;

        if($step <= $totalSteps) {
            $parser = new \App\Parser\Parser();
            return $parser->updatePrices($request);
        } else return null;
    }

    public function loadPricesXml()
    {
        $parser = new \App\Parser\Parser();
        $xmlLoaded = $parser->loadPricesXml();
        return $xmlLoaded;
    }

    public function getTotalProductsForUpdatePrices()
    {
        $parser = new \App\Parser\Parser();
        $totalNumberOfProducts = $parser->getTotalProductsForUpdatePrices();
        return $totalNumberOfProducts;
    }

    public function getPriceLastUpdatedAtTimestamps()
    {
        return Carbon::make(get_setting_by_key('price_last_updated_at'))->isoFormat('LLL');
    }

    public function updatePriceTimestamps()
    {
        $settings = Settings::find(1);

        if($settings) {
            $settings->price_last_updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $settings->save();
        }
        return Carbon::now()->isoFormat('LLL');
    }

    public function compareValidationAndUpdatingPricesDates()
    {
        $settings = Settings::find(1);

        if($settings) {
            if(Carbon::make($settings->xml_last_validated_at)->greaterThan(Carbon::make($settings->price_last_updated_at))) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}
