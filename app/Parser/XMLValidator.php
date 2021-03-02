<?php


namespace App\Parser;


use ErrorException;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class XMLValidator
{
    protected $xml;
    protected $current_instance;
    protected $url;
    protected $additional_xmls = [];
    public $errors = [];

    protected $xml_instances_pattern = 'brands|features|price|products|tags';

    public function __construct($filename)
    {
        if (App::environment() === 'local') {
            $this->url = storage_path('app/public/xml/');
        } elseif(App::environment() === 'production') {
            $this->url = Storage::disk('public')->url('xml');
        } else {
            $this->url = asset('/storage/xml/');
        }

        $this->validateFilename($filename);
        $file_xml_content = $this->loadFile($filename);
        $this->loadXMLContent($file_xml_content);
    }

    public function validateFilename($filename) : void
    {
        if(!preg_match("/^upload_($this->xml_instances_pattern)\.xml$/", $filename, $m)) {
            $this->errors['bad_filename'] = 'Неверное имя файла';
        } else {
            // get current instance by regular pattern
            $this->current_instance = $m[1];
        }
    }

    public function loadFile($filename) {
        try {
            return file_get_contents($this->url.'/'.$filename);
        } catch (ErrorException $exception) {
            $this->errors['filename_exception'] = $exception->getMessage();
        }
    }

    public function loadXMLContent($file_xml_content) : void
    {
        try {
            $this->xml = new \SimpleXMLElement($file_xml_content, LIBXML_BIGLINES);
        } catch (Exception $exception) {
            $this->errors['load_xml_exception'] = $exception->getMessage();
        }
    }

    public function validate()
    {
        if(!array_key_exists('load_xml_exception', $this->errors)) {
            switch ($this->current_instance) {
                case 'brands':
                    $countries_ids = $this->validateCountries();
                    $this->validateBrands($countries_ids);
                    break;
                case 'features':
                    $feature_type_ids = $this->validateFeatureTypes();
                    $this->validateFeatures($feature_type_ids);
                    break;
                case 'price':
                    $this->validatePrices();
                    break;
                case 'tags':
                    $this->validateTags();
                    break;
                case 'products':
                    $categories_ids = $this->validateCategories();
                    $collection_ids = $this->validateCollections($categories_ids);
                    $this->validateProducts($categories_ids, $collection_ids);
                    break;
                default:
                    $this->errors['not_found_filename'] = 'Не можем найти нужный файл для валидации';
            }
        }
    }

    public function validateBrands(array $countries_ids)
    {
        $brands = $this->xml->brands;

        if(empty($brands)) {
            $this->errors['brands'] = 'brands тег не был найден';
            return;
        }

        $this->validateAdditionalFilenames(['upload_products.xml']);
        $file_xmls_content = $this->loadAdditionalFiles(['upload_products.xml']);
        $this->loadAdditionalXMLsContent(['upload_products.xml'], $file_xmls_content);

        if(!array_key_exists('load_additional_xmls_exception', $this->errors)) {
            $brands_errors_count = 0;

            // CATEGORIES NEEDED TO CHECK BRAND CATEGORY EXISTENCE
            $categories = [];
            foreach ($this->additional_xmls['products']->categories->category as $category) {
                $categories[] = (string)$category->id;
            }
            //////////////////////////////////////////////////////

            foreach ($brands->brand as $brand) {
                // ID
                if(!isset($brand->id)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд id не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                } else if(empty($brand->id)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд id пуст.'.' Ошибка в строке '.(dom_import_simplexml($brand->id)->getLineNo());
                    $brands_errors_count++;
                } else if(!filter_var($brand->id, FILTER_VALIDATE_INT)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($brand->id)->getLineNo());
                    $brands_errors_count++;
                }

                // NAME
                if(!isset($brand->name)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд name не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                } else if(empty($brand->name)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд name пуст.'.' Ошибка в строке '.(dom_import_simplexml($brand->name)->getLineNo());
                    $brands_errors_count++;
                } else if(strlen($brand->name) > 255) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд name имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($brand->name)->getLineNo());
                    $brands_errors_count++;
                }

                // COUNTRY
                if(!isset($brand->country)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд country не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                } else if(empty($brand->country)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд country пуст.'.' Ошибка в строке '.(dom_import_simplexml($brand->country)->getLineNo());
                    $brands_errors_count++;
                } else if(!in_array($brand->country, $countries_ids)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд country_id не был найден в countries xml блоке. Xmls должны быть соответствующими'.' Ошибка в строке '.(dom_import_simplexml($brand->country)->getLineNo());
                    $brands_errors_count++;
                }

                // DESCRIPTION RU
                if(!isset($brand->description_ru)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд description_ru не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                }

                // DESCRIPTION RO
                if(!isset($brand->description_ro)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд description_ro не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                }

                // IMAGE
                if(!isset($brand->image)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд image не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                } else if(!preg_match('/^.+\.(jpg|png|jpeg)$/', $brand->image, $m)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд image имеет неверный тип файла. Должен быть png, jpg, jpeg.'.' Ошибка в строке '.(dom_import_simplexml($brand->image)->getLineNo());
                    $brands_errors_count++;
                }

                // CATEGORY
                if(!isset($brand->categories)) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд categories не существует в брендах. Пожалуйста, проверьте весь brands блок еще раз.';
                    $brands_errors_count++;
                } else if(empty($brand->categories) || empty($brand->categories->children())) {
                    $this->errors['brands'][$brands_errors_count] = 'Бренд categories пуст.'.' Ошибка в строке '.(dom_import_simplexml($brand->categories)->getLineNo());
                    $brands_errors_count++;
                } else {
                    foreach ($brand->categories->category_id as $category) {
                        if(empty($category)) {
                            $this->errors['brands'][$brands_errors_count] = 'Categories category_id пуст.'.' Ошибка в строке '.(dom_import_simplexml($category)->getLineNo());
                            $brands_errors_count++;
                        } else if(!in_array($category, $categories)) {
                            $this->errors['brands'][$brands_errors_count] = 'Бренд category не был найден в categories xml блоке. Xmls должны быть соответствующими'.' Ошибка в строке '.(dom_import_simplexml($category)->getLineNo());
                            $brands_errors_count++;
                        }
                    }
                }
            }
        }
    }

    public function validateCountries()
    {
        $countries = $this->xml->countries;

        if(empty($countries)) {
            $this->errors['countries'] = 'Тег countries не был найден';
            return;
        }

        $countries_errors_count = 0;
        $countries_ids = [];

        foreach ($countries->country as $country) {
            // ID
            if(!isset($country->id)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна id не существует в странах. Пожалуйста, проверьте весь countries блок еще раз.';
                $countries_errors_count++;
            } else if(empty($country->id)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна id пуст.'.' Ошибка в строке '.(dom_import_simplexml($country->id)->getLineNo());
                $countries_errors_count++;
            } else if(!filter_var($country->id, FILTER_VALIDATE_INT)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($country->id)->getLineNo());
                $countries_errors_count++;
            } else {
                $countries_ids[] = (int)$country->id;
            }

            // NAME RU
            if(!isset($country->name_ru)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна name_ru не существует в странах. Пожалуйста, проверьте весь countries блок еще раз.';
                $countries_errors_count++;
            } else if(empty($country->name_ru)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна name_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($country->name_ru)->getLineNo());
                $countries_errors_count++;
            } else if(strlen($country->name_ru) > 255) {
                $this->errors['countries'][$countries_errors_count] = 'Страна name_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($country->name_ru)->getLineNo());
                $countries_errors_count++;
            }

            // NAME RO
            if(!isset($country->name_ro)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна name_ro не существует в странах. Пожалуйста, проверьте весь countries блок еще раз.';
                $countries_errors_count++;
            } else if(empty($country->name_ro)) {
                $this->errors['countries'][$countries_errors_count] = 'Страна name_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($country->name_ro)->getLineNo());
                $countries_errors_count++;
            } else if(strlen($country->name_ro) > 255) {
                $this->errors['countries'][$countries_errors_count] = 'Страна name_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($country->name_ro)->getLineNo());
                $countries_errors_count++;
            }
        }

        return $countries_ids;
    }

    public function validateFeatureTypes()
    {
        $feature_types = $this->xml->feature_types;

        if(empty($feature_types)) {
            $this->errors['feature_types'] = 'Тег feature_types не был найден';
            return;
        }

        $this->validateAdditionalFilenames(['upload_products.xml']);
        $file_xmls_content = $this->loadAdditionalFiles(['upload_products.xml']);
        $this->loadAdditionalXMLsContent(['upload_products.xml'], $file_xmls_content);

        $feature_types_errors_count = 0;
        $feature_type_ids = [];

        // CATEGORIES NEEDED TO CHECK FEATURE TYPE CATEGORY EXISTENCE
        $categories = [];
        foreach ($this->additional_xmls['products']->categories->category as $category) {
            $categories[] = (string)$category->id;
        }
        //////////////////////////////////////////////////////

        foreach ($feature_types->feature_type as $feature_type) {
            // ID
            if(!isset($feature_type->id)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики id не существует в типах характеристик. Пожалуйста, проверьте весь feature_types блок еще раз.';
                $feature_types_errors_count++;
            } else if(empty($feature_type->id)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики id пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->id)->getLineNo());
                $feature_types_errors_count++;
            } else if(!filter_var($feature_type->id, FILTER_VALIDATE_INT)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->id)->getLineNo());
                $feature_types_errors_count++;
            } else {
                $feature_type_ids[] = (int)$feature_type->id;
            }

            // NAME RU
            if(!isset($feature_type->name_ru)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики name_ru не существует в типах характеристик. Пожалуйста, проверьте весь feature_types блок еще раз.';
                $feature_types_errors_count++;
            } else if(empty($feature_type->name_ru)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики name_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->name_ru)->getLineNo());
                $feature_types_errors_count++;
            } else if(strlen($feature_type->name_ru) > 255) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики name_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->name_ru)->getLineNo());
                $feature_types_errors_count++;
            }

            // NAME RO
            if(!isset($feature_type->name_ro)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики name_ro не существует в типах характеристик. Пожалуйста, проверьте весь feature_types блок еще раз.';
                $feature_types_errors_count++;
            } else if(empty($feature_type->name_ro)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики name_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->name_ro)->getLineNo());
                $feature_types_errors_count++;
            } else if(strlen($feature_type->name_ro) > 255) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики name_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->name_ro)->getLineNo());
                $feature_types_errors_count++;
            }

            // ADD TO FILTER
            if(!isset($feature_type->addtofilter)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики add to filter не существует в типах характеристик. Пожалуйста, проверьте весь feature_types блок еще раз.';
                $feature_types_errors_count++;
            } else if(!isset($feature_type->addtofilter)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики add to filter пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->addtofilter)->getLineNo());
                $feature_types_errors_count++;
            } else if((int)$feature_type->addtofilter !== 1 && (int)$feature_type->addtofilter !== 0) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики add to filter значение должно быть 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->addtofilter)->getLineNo());
                $feature_types_errors_count++;
            }

            // FILTER TYPE
            if(!isset($feature_type->filter_type)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики filter_type не существует в типах характеристик. Пожалуйста, проверьте весь feature_types блок еще раз.';
                $feature_types_errors_count++;
            } else if(empty($feature_type->filter_type)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики filter_type пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->filter_type)->getLineNo());
                $feature_types_errors_count++;
            } else if(strlen($feature_type->filter_type) > 255) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики filter_type имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->filter_type)->getLineNo());
                $feature_types_errors_count++;
            } else if((string)$feature_type->filter_type !== 'checkbox' && (string)$feature_type->filter_type !== 'input') {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики filter_type значение должно быть "input" или "checkbox".'.' Ошибка в строке '.(dom_import_simplexml($feature_type->filter_type)->getLineNo());
                $feature_types_errors_count++;
            }

            // CATEGORIES
            if(!isset($feature_type->categories)) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики categories не существует в типах характеристик. Пожалуйста, проверьте весь feature_types блок еще раз.';
                $feature_types_errors_count++;
            } else if(empty($feature_type->categories) || empty($feature_type->categories->children())) {
                $this->errors['feature_types'][$feature_types_errors_count] = 'Тип характеристики categories пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature_type->categories)->getLineNo());
                $feature_types_errors_count++;
            } else {
                foreach ($feature_type->categories->category_id as $category) {
                    if(empty($category)) {
                        $this->errors['feature_types'][$feature_types_errors_count] = 'Categories category_id пуст.'.' Ошибка в строке '.(dom_import_simplexml($category)->getLineNo());
                        $feature_types_errors_count++;
                    } else if(!in_array($category, $categories)) {
                        $this->errors['feature_types'][$feature_types_errors_count] = 'This feature type category не существоует в соответствующем xml categories. Xmls должны соответствовать друг другу'.' Ошибка в строке '.(dom_import_simplexml($category)->getLineNo());
                        $feature_types_errors_count++;
                    }
                }
            }
        }

        return $feature_type_ids;
    }

    public function validateFeatures($feature_type_ids)
    {
        $features = $this->xml->features;

        if(empty($features)) {
            $this->errors['features'] = 'Тег features не был найден';
            return;
        }

        $features_errors_count = 0;

        foreach ($features->feature as $feature) {
            // ID
            if(!isset($feature->id)) {
                $this->errors['features'][$features_errors_count] = 'Feature id не существует в характеристиках. Пожалуйста, проверьте весь features блок еще раз.';
                $features_errors_count++;
            } else if(empty($feature->id)) {
                $this->errors['features'][$features_errors_count] = 'Feature id пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature->id)->getLineNo());
                $features_errors_count++;
            } else if(!filter_var($feature->id, FILTER_VALIDATE_INT)) {
                $this->errors['features'][$features_errors_count] = 'Feature id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($feature->id)->getLineNo());
                $features_errors_count++;
            }

            // VALUE RU
            if(!isset($feature->value_ru)) {
                $this->errors['features'][$features_errors_count] = 'Feature value_ru не существует в характеристиках. Пожалуйста, проверьте весь features блок еще раз.';
                $features_errors_count++;
            } else if(empty($feature->value_ru)) {
                $this->errors['features'][$features_errors_count] = 'Feature value_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature->value_ru)->getLineNo());
                $features_errors_count++;
            } else if(strlen($feature->value_ru) > 255) {
                $this->errors['features'][$features_errors_count] = 'Feature value_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($feature->value_ru)->getLineNo());
                $features_errors_count++;
            }

            // VALUE RO
            if(!isset($feature->value_ro)) {
                $this->errors['features'][$features_errors_count] = 'Feature value_ro не существует в характеристиках. Пожалуйста, проверьте весь features блок еще раз.';
                $features_errors_count++;
            } else if(empty($feature->value_ro)) {
                $this->errors['features'][$features_errors_count] = 'Feature value_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature->value_ro)->getLineNo());
                $features_errors_count++;
            } else if(strlen($feature->value_ro) > 255) {
                $this->errors['features'][$features_errors_count] = 'Feature value_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($feature->value_ro)->getLineNo());
                $features_errors_count++;
            }

            // FEATURE TYPE ID
            if(!isset($feature->id_feature_type)) {
                $this->errors['features'][$features_errors_count] = 'Feature feature type id не существует в характеристиках. Пожалуйста, проверьте весь features блок еще раз.';
                $features_errors_count++;
            } else if(empty($feature->id_feature_type)) {
                $this->errors['features'][$features_errors_count] = 'Feature feature type id пуст.'.' Ошибка в строке '.(dom_import_simplexml($feature->id_feature_type)->getLineNo());
                $features_errors_count++;
            } else if(!in_array($feature->id_feature_type, $feature_type_ids)) {
                $this->errors['features'][$features_errors_count] = 'This Feature feature type не существует в xml. Xmls должны соответствовать друг другу'.' Ошибка в строке '.(dom_import_simplexml($feature->id_feature_type)->getLineNo());
                $features_errors_count++;
            }
        }
    }

    public function validatePrices()
    {
        $product_prices = $this->xml->products;

        if(empty($product_prices)) {
            $this->errors['prices'] = 'Тег products не был найден';
            return;
        }

        $this->validateAdditionalFilenames(['upload_products.xml']);
        $file_xmls_content = $this->loadAdditionalFiles(['upload_products.xml']);
        $this->loadAdditionalXMLsContent(['upload_products.xml'], $file_xmls_content);

        $prices_errors_count = 0;

        // PRODUCTS NEEDED TO CHECK PRODUCT FOR PRICE EXISTENCE
        $products = [];
        foreach ($this->additional_xmls['products']->products->product as $product) {
            $products[] = (string)$product->id;
        }
        //////////////////////////////////////////////////////

        // COLLECTIONS NEEDED TO CHECK COLLECTION FOR PRICE EXISTENCE
        $collections = [];
        foreach ($this->additional_xmls['products']->tiles_collections->tiles_collection as $collection) {
            $collections[] = (string)$collection->id;
        }
        //////////////////////////////////////////////////////

        foreach ($product_prices->product as $product) {
            // PRODUCT ID
            if(!isset($product->product_id)) {
                $this->errors['prices'][$prices_errors_count] = 'Product id не существует в ценах. Пожалуйста, проверьте весь product prices блок еще раз.';
                $prices_errors_count++;
            } else if(empty($product->product_id)) {
                $this->errors['prices'][$prices_errors_count] = 'Product id пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->product_id)->getLineNo());
                $prices_errors_count++;
            } else if(!filter_var($product->product_id, FILTER_VALIDATE_INT)) {
                $this->errors['prices'][$prices_errors_count] = 'Product id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($product->product_id)->getLineNo());
                $prices_errors_count++;
            } else if(!in_array($product->product_id, $products) && !in_array($product->product_id, $collections)) {
                $this->errors['prices'][$prices_errors_count] = 'This product id не существует в products xml блоке или в collections xml блоке. Xmls должны соответствовать друг другу'.' Ошибка в строке '.(dom_import_simplexml($product->product_id)->getLineNo());
                $prices_errors_count++;
            }

            // PRICE
            if(!isset($product->price)) {
                $this->errors['prices'][$prices_errors_count] = 'Product price не существует в ценах. Пожалуйста, проверьте весь product prices блок еще раз.';
                $prices_errors_count++;
            } else if(empty($product->price)) {
                $this->errors['prices'][$prices_errors_count] = 'Product price пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->price)->getLineNo());
                $prices_errors_count++;
            } else if(isset($product->price) && !empty($product->price) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $product->price)) {
                $this->errors['prices'][$prices_errors_count] = 'Product price не integer или float значение.'.' Ошибка в строке '.(dom_import_simplexml($product->price)->getLineNo());
                $prices_errors_count++;
            } else if((string)$product->price === "0") {
                $this->errors['prices'][$prices_errors_count] = 'Product discount price не может быть 0.'.' Ошибка в строке '.(dom_import_simplexml($product->price)->getLineNo());
                $prices_errors_count++;
            }

            // DISCOUNT PRICE
            if(!isset($product->discount_price)) {
                $this->errors['prices'][$prices_errors_count] = 'Product discount price не существует в ценах. Пожалуйста, проверьте весь product prices блок еще раз.';
                $prices_errors_count++;
            } else if(isset($product->discount_price) && !empty($product->discount_price) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $product->discount_price)) {
                $this->errors['prices'][$prices_errors_count] = 'Product discount price не integer или float значение.'.' Ошибка в строке '.(dom_import_simplexml($product->discount_price)->getLineNo());
                $prices_errors_count++;
            } else if((string)$product->discount_price === "0") {
                $this->errors['prices'][$prices_errors_count] = 'Product discount price не может быть 0.'.' Ошибка в строке '.(dom_import_simplexml($product->discount_price)->getLineNo());
                $prices_errors_count++;
            }

            // STOCK
            if(!isset($product->stock)) {
                $this->errors['prices'][$prices_errors_count] = 'Product stock не существует в ценах. Пожалуйста, проверьте весь product prices блок еще раз.';
                $prices_errors_count++;
            } else if(isset($product->stock) && !empty($product->stock) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $product->stock)) {
                $this->errors['prices'][$prices_errors_count] = 'Product stock не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($product->stock)->getLineNo());
                $prices_errors_count++;
            }
        }
    }

    public function validateTags()
    {
        $tags = $this->xml->tags;

        if(empty($tags)) {
            $this->errors['tags'] = 'Тег tags не был найден';
            return;
        }

        $tags_errors_count = 0;

        foreach ($tags->tag as $tag) {
            // ID
            if(!isset($tag->id)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag id не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            } else if(empty($tag->id)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag id пуст.'.' Ошибка в строке '.(dom_import_simplexml($tag->id)->getLineNo());
                $tags_errors_count++;
            } else if(!filter_var($tag->id, FILTER_VALIDATE_INT)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($tag->id)->getLineNo());
                $tags_errors_count++;
            }

            // NAME RU
            if(!isset($tag->name_ru)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag name_ru не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            } else if(empty($tag->name_ru)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag name_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($tag->name_ru)->getLineNo());
                $tags_errors_count++;
            } else if(strlen($tag->name_ru) > 255) {
                $this->errors['tags'][$tags_errors_count] = 'Tag name_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($tag->name_ru)->getLineNo());
                $tags_errors_count++;
            }

            // NAME RO
            if(!isset($tag->name_ro)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag name_ro не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            } else if(empty($tag->name_ro)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag name_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($tag->name_ro)->getLineNo());
                $tags_errors_count++;
            } else if(strlen($tag->name_ro) > 255) {
                $this->errors['tags'][$tags_errors_count] = 'Tag name_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($tag->name_ro)->getLineNo());
                $tags_errors_count++;
            }

            // DISCOUNT
            if(!isset($tag->discount)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag discount не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            } else if(strlen((string)$tag->discount) === 0) {
                $this->errors['tags'][$tags_errors_count] = 'Tag discount пуст.'.' Ошибка в строке '.(dom_import_simplexml($tag->discount)->getLineNo());
                $tags_errors_count++;
            } else if(!preg_match('/^\d+$/', $tag->discount)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag discount должно иметь integer значение.'.' Ошибка в строке '.(dom_import_simplexml($tag->discount)->getLineNo());
                $tags_errors_count++;
            } else if((string)$tag->discount !== "0" && (int)$tag->discount >= 100 && preg_match('/^\d+$/', $tag->discount)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag discount должно иметь значение integer 0 или < 100.'.' Ошибка в строке '.(dom_import_simplexml($tag->discount)->getLineNo());
                $tags_errors_count++;
            }

            // IMAGE
            if(!isset($tag->image)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag image не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            } else if(!preg_match('/^\/?promotions\/.+\.(jpg|png|jpeg)$/', $tag->image, $m)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag image имеет неверный тип файла. Должен быть png, jpg, jpeg.'.' Ошибка в строке '.(dom_import_simplexml($tag->image)->getLineNo());
                $tags_errors_count++;
            }

            // DESCRIPTION RU
            if(!isset($tag->description_ru)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag description_ru не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            }

            // DESCRIPTION RO
            if(!isset($tag->description_ro)) {
                $this->errors['tags'][$tags_errors_count] = 'Tag description_ro не существует в тегах. Пожалуйста, проверьте весь tags блок еще раз.';
                $tags_errors_count++;
            }
        }
    }

    public function validateCategories()
    {
        $categories = $this->xml->categories;

        if(empty($categories)) {
            $this->errors['categories'] = 'Тег categories не был найден';
            return;
        }

        $categories_errors_count = 0;
        $categories_ids = [];

        foreach ($categories->category as $category) {
            // ID
            if(!isset($category->id)) {
                $this->errors['categories'][$categories_errors_count] = 'Category id не существует в категориях. Пожалуйста, проверьте весь categories блок еще раз.';
                $categories_errors_count++;
            } else if(empty($category->id)) {
                $this->errors['categories'][$categories_errors_count] = 'Category id пуст.'.' Ошибка в строке '.(dom_import_simplexml($category->id)->getLineNo());
                $categories_errors_count++;
            } else if(!preg_match('/^00-0{2,5}\d+$/', $category->id)) {
                $this->errors['categories'][$categories_errors_count] = 'Category id не integer значение в формате 00-00002345.'.' Ошибка в строке '.(dom_import_simplexml($category->id)->getLineNo());
                $categories_errors_count++;
            } else {
                $categories_ids[] = (string)$category->id;
            }

            // PARENT ID
            if(!isset($category->parent_id)) {
                $this->errors['categories'][$categories_errors_count] = 'Category parent id не существует в категориях. Пожалуйста, проверьте весь categories блок еще раз.';
                $categories_errors_count++;
            } else if(!empty($category->parent_id) && !preg_match('/^00-0{2,5}\d+$/', $category->parent_id)) {
                $this->errors['categories'][$categories_errors_count] = 'Category parent id не значение в формате 00-00002345.'.' Ошибка в строке '.(dom_import_simplexml($category->parent_id)->getLineNo());
                $categories_errors_count++;
            } else if(!empty($category->parent_id)) {
                $flag = false;
                $parent_id = (int)str_replace('00-', '', $category->parent_id);

                foreach ($categories->category as $c) {
                    if((int)str_replace('00-', '', $c->id) === $parent_id) {
                        $flag = true;
                    }
                }

                if(!$flag) {
                    $this->errors['categories'][$categories_errors_count] = 'Category parent не был найден в categories xml.'.' Ошибка в строке '.(dom_import_simplexml($category->parent_id)->getLineNo());
                    $categories_errors_count++;
                }
            }

            // NAME RU
            if(!isset($category->name_ru)) {
                $this->errors['categories'][$categories_errors_count] = 'Category name_ru не существует в категориях. Пожалуйста, проверьте весь categories блок еще раз.';
                $categories_errors_count++;
            } else if(empty($category->name_ru)) {
                $this->errors['categories'][$categories_errors_count] = 'Category name_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($category->name_ru)->getLineNo());
                $categories_errors_count++;
            } else if(strlen($category->name_ru) > 255) {
                $this->errors['categories'][$categories_errors_count] = 'Category name_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($category->name_ru)->getLineNo());
                $categories_errors_count++;
            }

            // NAME RO
            if(!isset($category->name_ro)) {
                $this->errors['categories'][$categories_errors_count] = 'Category name_ro не существует в категориях. Пожалуйста, проверьте весь categories блок еще раз.';
                $categories_errors_count++;
            } else if(empty($category->name_ro)) {
                $this->errors['categories'][$categories_errors_count] = 'Category name_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($category->name_ro)->getLineNo());
                $categories_errors_count++;
            } else if(strlen($category->name_ro) > 255) {
                $this->errors['categories'][$categories_errors_count] = 'Category name_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($category->name_ro)->getLineNo());
                $categories_errors_count++;
            }

            // IS ACTIVE
            if(!isset($category->is_active)) {
                $this->errors['categories'][$categories_errors_count] = 'Category is active не существует в категориях. Пожалуйста, проверьте весь categories блок еще раз.';
                $categories_errors_count++;
            } else if(!isset($category->is_active)) {
                $this->errors['categories'][$categories_errors_count] = 'Category is active пуст.'.' Ошибка в строке '.(dom_import_simplexml($category->is_active)->getLineNo());
                $categories_errors_count++;
            } else if((int)$category->is_active !== 1 && (int)$category->is_active !== 0) {
                $this->errors['categories'][$categories_errors_count] = 'Category is active значение должно быть 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($category->is_active)->getLineNo());
                $categories_errors_count++;
            }
        }

        return $categories_ids;
    }

    public function validateCollections($categories_ids)
    {
        $collections = $this->xml->tiles_collections;

        if(empty($collections)) {
            $this->errors['collections'] = 'Тег tiles collections не был найден';
            return;
        }

        $this->validateAdditionalFilenames(['upload_brands.xml', 'upload_features.xml']);
        $file_xmls_content = $this->loadAdditionalFiles(['upload_brands.xml', 'upload_features.xml']);
        $this->loadAdditionalXMLsContent(['upload_brands.xml', 'upload_features.xml'], $file_xmls_content);

        $collections_errors_count = 0;
        $collections_ids = [];

        // BRANDS NEEDED TO CHECK COLLECTION BRAND EXISTENCE
        $brands = [];
        foreach ($this->additional_xmls['brands']->brands->brand as $brand) {
            $brands[] = (string)$brand->id;
        }
        //////////////////////////////////////////////////////

        // FEATURES NEEDED TO CHECK COLLECTION FEATURES EXISTENCE
        $features = [];
        foreach ($this->additional_xmls['features']->features->feature as $feature) {
            $features[] = (string)$feature->id;
        }
        //////////////////////////////////////////////////////

        // PRODUCTS NEEDED TO CHECK COLLECTION SET PRODUCTS EXISTENCE
        $prods = [];
        foreach ($this->xml->products->product as $product) {
            $prods[] = (int)$product->id;
        }
        //////////////////////////////////////////////////////

        foreach ($collections->tiles_collection as $tiles_collection) {
            // ID
            if(!isset($tiles_collection->id)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection id не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->id)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection id пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->id)->getLineNo());
                $collections_errors_count++;
            } else if(!filter_var($tiles_collection->id, FILTER_VALIDATE_INT)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->id)->getLineNo());
                $collections_errors_count++;
            } else {
                $collections_ids[] = (string)$tiles_collection->id;
            }

            // CATEGORY ID
            if(!isset($tiles_collection->category_id)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection category id не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(!empty($tiles_collection->category_id) && !preg_match('/^00-0{2,5}\d+$/', $tiles_collection->category_id)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection category id не значение в формате 00-00002345.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->category_id)->getLineNo());
                $collections_errors_count++;
            } else if(!empty($tiles_collection->category_id) && !in_array($tiles_collection->category_id, $categories_ids)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection category не был найден в categories xml.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->category_id)->getLineNo());
                $collections_errors_count++;
            }

            // NAME RU
            if(!isset($tiles_collection->name_ru)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection name_ru не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->name_ru)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection name_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->name_ru)->getLineNo());
                $collections_errors_count++;
            } else if(strlen($tiles_collection->name_ru) > 255) {
                $this->errors['collections'][$collections_errors_count] = 'Collection name_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->name_ru)->getLineNo());
                $collections_errors_count++;
            }

            // NAME RO
            if(!isset($tiles_collection->name_ro)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection name_ro не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->name_ro)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection name_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->name_ro)->getLineNo());
                $collections_errors_count++;
            } else if(strlen($tiles_collection->name_ro) > 255) {
                $this->errors['collections'][$collections_errors_count] = 'Collection name_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->name_ro)->getLineNo());
                $collections_errors_count++;
            }

            // UNIT RU
            if(!isset($tiles_collection->unit_ru)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection unit ru не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->unit_ru)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection unit ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->unit_ru)->getLineNo());
                $collections_errors_count++;
            } else if(strlen($tiles_collection->unit_ru) > 10) {
                $this->errors['collections'][$collections_errors_count] = 'Collection unit ru более чем 10 символов длиной.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->unit_ru)->getLineNo());
                $collections_errors_count++;
            }

            // UNIT RO
            if(!isset($tiles_collection->unit_ro)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection unit ro не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->unit_ro)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection unit ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->unit_ro)->getLineNo());
                $collections_errors_count++;
            } else if(strlen($tiles_collection->unit_ro) > 10) {
                $this->errors['collections'][$collections_errors_count] = 'Collection unit ro более чем 10 символов длиной.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->unit_ro)->getLineNo());
                $collections_errors_count++;
            }

            // DESCRIPTION RU
            if(!isset($tiles_collection->description_ru)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection description_ru не существует в коллекциях. Пожалуйста, проверьте весь products блок еще раз.';
                $collections_errors_count++;
            }

            // DESCRIPTION RO
            if(!isset($tiles_collection->description_ro)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection description_ro не существует в коллекциях. Пожалуйста, проверьте весь tiles_collections блок еще раз.';
                $collections_errors_count++;
            }

            // PRICE
            if(!isset($tiles_collection->price)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection price не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->price)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection price пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->price)->getLineNo());
                $collections_errors_count++;
            } else if(isset($tiles_collection->price) && !empty($tiles_collection->price) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $tiles_collection->price)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection price не integer или float значение.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->price)->getLineNo());
                $collections_errors_count++;
            } else if((string)$tiles_collection->price === "0") {
                $this->errors['collections'][$collections_errors_count] = 'Collection price не может быть 0.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->price)->getLineNo());
                $collections_errors_count++;
            }

            // DISCOUNT PRICE
            if(!isset($tiles_collection->discount_price)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection discount price не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(isset($tiles_collection->discount_price) && !empty($tiles_collection->discount_price) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $tiles_collection->discount_price)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection discount price не integer или float значение.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->discount_price)->getLineNo());
                $collections_errors_count++;
            } else if((string)$tiles_collection->discount_price === "0") {
                $this->errors['collections'][$collections_errors_count] = 'Collection discount price не может быть 0.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->discount_price)->getLineNo());
                $collections_errors_count++;
            }

            // IS VISIBLE
            if(!isset($tiles_collection->is_visible)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection is visible не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(!isset($tiles_collection->is_visible)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection is visible пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->is_visible)->getLineNo());
                $collections_errors_count++;
            } else if((int)$tiles_collection->is_visible !== 1 && (int)$tiles_collection->is_visible !== 0) {
                $this->errors['collections'][$collections_errors_count] = 'Collection is visible значение должно быть 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->is_visible)->getLineNo());
                $collections_errors_count++;
            }

            // BRAND
            if(!isset($tiles_collection->brand)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection brand не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(!isset($tiles_collection->brand)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection brand пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->brand)->getLineNo());
                $collections_errors_count++;
            } else if(!empty($tiles_collection->brand) && !in_array($tiles_collection->brand, $brands)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection brand не был найден в brands xml.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->brand)->getLineNo());
                $collections_errors_count++;
            }

            // FEATURES
            if(!isset($tiles_collection->features)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection features не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else {
                foreach ($tiles_collection->features->feature_id as $feature) {
                    if(!in_array($feature, $features)) {
                        $this->errors['collections'][$collections_errors_count] = 'Collection feature не был найден в features xml.'.' Ошибка в строке '.(dom_import_simplexml($feature)->getLineNo());
                        $collections_errors_count++;
                    }
                }
            }

            // IMAGES
            if(!isset($tiles_collection->images)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection images не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->images) || empty($tiles_collection->images->children())) {
                $this->errors['collections'][$collections_errors_count] = 'Collection images пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->images)->getLineNo());
                $collections_errors_count++;
            } else {
                foreach ($tiles_collection->images->image as $image) {
                    if(empty($image)) {
                        $this->errors['collections'][$collections_errors_count] = 'Collection images image пуст.'.' Ошибка в строке '.(dom_import_simplexml($image)->getLineNo());
                        $collections_errors_count++;
                    } else if(!preg_match('/^.+\.(jpg|png|jpeg)$/', $image, $m)) {
                        $this->errors['collections'][$collections_errors_count] = 'Collection images image имеет неверный тип файла. Должен быть png, jpg, jpeg.'.' Ошибка в строке '.(dom_import_simplexml($image)->getLineNo());
                        $collections_errors_count++;
                    }
                }
            }

            // SET
            if(!isset($tiles_collection->set)) {
                $this->errors['collections'][$collections_errors_count] = 'Collection set не существует в коллекциях. Пожалуйста, проверьте весь collections блок еще раз.';
                $collections_errors_count++;
            } else if(empty($tiles_collection->set) || empty($tiles_collection->set->children())) {
                $this->errors['collections'][$collections_errors_count] = 'Collection set пуст.'.' Ошибка в строке '.(dom_import_simplexml($tiles_collection->set)->getLineNo());
                $collections_errors_count++;
            } else {
                foreach ($tiles_collection->set->id_product as $product) {
                    if(!in_array($product, $prods)) {
                        $this->errors['collections'][$collections_errors_count] = 'Collection set product не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($product)->getLineNo());
                        $collections_errors_count++;
                    }

                    if((int)$product['in_kit_only'] !== 0 && (int)$product['in_kit_only'] !== 1) {
                        $this->errors['collections'][$collections_errors_count] = 'Collection set product in kit only атрибут должен иметь значение 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($product)->getLineNo());
                        $collections_errors_count++;
                    }
                }
            }
        }

        return $collections_ids;
    }

    public function validateProducts($categories_ids, $collection_ids)
    {
        $products = $this->xml->products;

        if(empty($products)) {
            $this->errors['products'] = 'Тег products не был найден';
            return;
        }

        $this->validateAdditionalFilenames(['upload_brands.xml', 'upload_features.xml', 'upload_tags.xml']);
        $file_xmls_content = $this->loadAdditionalFiles(['upload_brands.xml', 'upload_features.xml', 'upload_tags.xml']);
        $this->loadAdditionalXMLsContent(['upload_brands.xml', 'upload_features.xml', 'upload_tags.xml'], $file_xmls_content);

        $products_errors_count = 0;

        // BRANDS NEEDED TO CHECK PRODUCT BRAND EXISTENCE
        $brands = [];
        foreach ($this->additional_xmls['brands']->brands->brand as $brand) {
            $brands[] = (string)$brand->id;
        }
        //////////////////////////////////////////////////////

        // FEATURES NEEDED TO CHECK PRODUCT FEATURES EXISTENCE
        $features = [];
        foreach ($this->additional_xmls['features']->features->feature as $feature) {
            $features[] = (string)$feature->id;
        }
        //////////////////////////////////////////////////////

        // PRODUCTS NEEDED TO CHECK PRODUCT SIZE ARRAY AND COLOR ARRAY EXISTENCE
        $prods = [];
        foreach ($this->xml->products->product as $product) {
            $prods[] = (int)$product->id;
        }
        //////////////////////////////////////////////////////

        // TAGS NEEDED TO CHECK PRODUCT TAGS EXISTENCE
        $tags = [];
        foreach ($this->additional_xmls['tags']->tags->tag as $tag) {
            $tags[] = (int)$tag->id;
        }
        //////////////////////////////////////////////////////

        foreach ($products->product as $product) {
            // ID
            if(!isset($product->id)) {
                $this->errors['products'][$products_errors_count] = 'Product id не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->id)) {
                $this->errors['products'][$products_errors_count] = 'Product id пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->id)->getLineNo());
                $products_errors_count++;
            } else if(!filter_var($product->id, FILTER_VALIDATE_INT)) {
                $this->errors['products'][$products_errors_count] = 'Product id не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($product->id)->getLineNo());
                $products_errors_count++;
            }

            // CATEGORY ID
            if(!isset($product->category_id)) {
                $this->errors['products'][$products_errors_count] = 'Product category id не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->category_id) && !preg_match('/^00-0{2,5}\d+$/', $product->category_id)) {
                $this->errors['products'][$products_errors_count] = 'Product category id не значение в формате 00-00002345.'.' Ошибка в строке '.(dom_import_simplexml($product->category_id)->getLineNo());
                $products_errors_count++;
            } else if(!empty($product->category_id) && !in_array($product->category_id, $categories_ids)) {
                $this->errors['products'][$products_errors_count] = 'Product category не был найден в categories xml.'.' Ошибка в строке '.(dom_import_simplexml($product->category_id)->getLineNo());
                $products_errors_count++;
            }

            // NAME RU
            if(!isset($product->name_ru)) {
                $this->errors['products'][$products_errors_count] = 'Product name_ru не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->name_ru)) {
                $this->errors['products'][$products_errors_count] = 'Product name_ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->name_ru)->getLineNo());
                $products_errors_count++;
            } else if(strlen($product->name_ru) > 255) {
                $this->errors['products'][$products_errors_count] = 'Product name_ru имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($product->name_ru)->getLineNo());
                $products_errors_count++;
            }

            // NAME RO
            if(!isset($product->name_ro)) {
                $this->errors['products'][$products_errors_count] = 'Product name_ro не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->name_ro)) {
                $this->errors['products'][$products_errors_count] = 'Product name_ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->name_ro)->getLineNo());
                $products_errors_count++;
            } else if(strlen($product->name_ro) > 255) {
                $this->errors['products'][$products_errors_count] = 'Product name_ro имеет длину более чем 255 символов.'.' Ошибка в строке '.(dom_import_simplexml($product->name_ro)->getLineNo());
                $products_errors_count++;
            }

            // COLLECTION ID
            if(!isset($product->collection_id)) {
                $this->errors['products'][$products_errors_count] = 'Product collection id не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if (!empty($product->collection_id) && !in_array($product->collection_id, $collection_ids)) {
                $this->errors['products'][$products_errors_count] = 'Product collection id не был найден в collections xml block.'.' Ошибка в строке '.(dom_import_simplexml($product->collection_id)->getLineNo());
                $products_errors_count++;
            }

            // UNIT RU
            if(!isset($product->unit_ru)) {
                $this->errors['products'][$products_errors_count] = 'Product unit ru не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->unit_ru)) {
                $this->errors['products'][$products_errors_count] = 'Product unit ru пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->unit_ru)->getLineNo());
                $products_errors_count++;
            } else if(strlen($product->unit_ru) > 10) {
                $this->errors['products'][$products_errors_count] = 'Product unit ru более чем 10 символов длиной.'.' Ошибка в строке '.(dom_import_simplexml($product->unit_ru)->getLineNo());
                $products_errors_count++;
            }

            // UNIT RO
            if(!isset($product->unit_ro)) {
                $this->errors['products'][$products_errors_count] = 'Product unit ro не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->unit_ro)) {
                $this->errors['products'][$products_errors_count] = 'Product unit ro пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->unit_ro)->getLineNo());
                $products_errors_count++;
            } else if(strlen($product->unit_ro) > 10) {
                $this->errors['products'][$products_errors_count] = 'Product unit ro более чем 10 символов длиной.'.' Ошибка в строке '.(dom_import_simplexml($product->unit_ro)->getLineNo());
                $products_errors_count++;
            }

            // RECOMMENDED
            if(!isset($product->recommended)) {
                $this->errors['products'][$products_errors_count] = 'Product recommended не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!isset($product->recommended)) {
                $this->errors['products'][$products_errors_count] = 'Product recommended пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->recommended)->getLineNo());
                $products_errors_count++;
            } else if((int)$product->recommended !== 1 && (int)$product->recommended !== 0) {
                $this->errors['products'][$products_errors_count] = 'Product recommended значение должно быть 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($product->recommended)->getLineNo());
                $products_errors_count++;
            }

            // PRICE
            if(!isset($product->price)) {
                $this->errors['products'][$products_errors_count] = 'Product price не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->price)) {
                $this->errors['products'][$products_errors_count] = 'Product price пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->price)->getLineNo());
                $products_errors_count++;
            } else if(isset($product->price) && !empty($product->price) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $product->price)) {
                $this->errors['products'][$products_errors_count] = 'Product price не integer или float значение.'.' Ошибка в строке '.(dom_import_simplexml($product->price)->getLineNo());
                $products_errors_count++;
            } else if((string)$product->price === "0") {
                $this->errors['products'][$products_errors_count] = 'Product price не может быть 0.'.' Ошибка в строке '.(dom_import_simplexml($product->price)->getLineNo());
                $products_errors_count++;
            }

            // DISCOUNT PRICE
            if(!isset($product->discount_price)) {
                $this->errors['products'][$products_errors_count] = 'Product discount price не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(isset($product->discount_price) && !empty($product->discount_price) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $product->discount_price)) {
                $this->errors['products'][$products_errors_count] = 'Product discount price не integer или float значение.'.' Ошибка в строке '.(dom_import_simplexml($product->discount_price)->getLineNo());
                $products_errors_count++;
            } else if((string)$product->discount_price === "0" || (string)$product->discount_price === "0.00") {
                $this->errors['products'][$products_errors_count] = 'Product discount price не может быть 0.'.' Ошибка в строке '.(dom_import_simplexml($product->discount_price)->getLineNo());
                $products_errors_count++;
            }

            // STOCK
            if(!isset($product->stock)) {
                $this->errors['products'][$products_errors_count] = 'Product stock не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(isset($product->stock) && !empty($product->stock) && !preg_match('/^\d+$|^\d+\.\d{1,3}$/', $product->stock)) {
                $this->errors['products'][$products_errors_count] = 'Product stock не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($product->stock)->getLineNo());
                $products_errors_count++;
            }

            // IS VISIBLE
            if(!isset($product->is_visible)) {
                $this->errors['products'][$products_errors_count] = 'Product is visible не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!isset($product->is_visible)) {
                $this->errors['products'][$products_errors_count] = 'Product is visible пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->is_visible)->getLineNo());
                $products_errors_count++;
            } else if((int)$product->is_visible !== 1 && (int)$product->is_visible !== 0) {
                $this->errors['products'][$products_errors_count] = 'Product is visible значение должно быть 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($product->is_visible)->getLineNo());
                $products_errors_count++;
            }

            // WARRANTY
            if(!isset($product->warranty)) {
                $this->errors['products'][$products_errors_count] = 'Product warranty не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!isset($product->warranty)) {
                $this->errors['products'][$products_errors_count] = 'Product warranty пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->warranty)->getLineNo());
                $products_errors_count++;
            } else if(!filter_var($product->warranty, FILTER_VALIDATE_INT)) {
                $this->errors['products'][$products_errors_count] = 'Product warranty не integer значение.'.' Ошибка в строке '.(dom_import_simplexml($product->warranty)->getLineNo());
                $products_errors_count++;
            } else if((string)$product->warranty['type'] !== 'day' && (string)$product->warranty['type'] !== 'month' && (string)$product->warranty['type'] !== 'year') {
                $this->errors['products'][$products_errors_count] = 'Product warranty type должен иметь значение year, month или day.'.' Ошибка в строке '.(dom_import_simplexml($product->warranty)->getLineNo());
                $products_errors_count++;
            }

            // BRAND
            if(!isset($product->brand)) {
                $this->errors['products'][$products_errors_count] = 'Product brand не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!isset($product->brand)) {
                $this->errors['products'][$products_errors_count] = 'Product brand пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->brand)->getLineNo());
                $products_errors_count++;
            } else if(!empty($product->brand) && !in_array($product->brand, $brands)) {
                $this->errors['products'][$products_errors_count] = 'Product brand не был найден в brands xml.'.' Ошибка в строке '.(dom_import_simplexml($product->brand)->getLineNo());
                $products_errors_count++;
            }

            // COLOR
            if(!isset($product->color)) {
                $this->errors['products'][$products_errors_count] = 'Product color не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->color)) {
                $colors = explode(',', $product->color);

                foreach ($colors as $c) {
                    if(!preg_match('/^\#[0-9a-zA-Z]{6}$/', $c)) {
                        $this->errors['products'][$products_errors_count] = 'Product color hex неверен.'.' Ошибка в строке '.(dom_import_simplexml($product->color)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // TAGS
            if(!isset($product->tags)) {
                $this->errors['products'][$products_errors_count] = 'Product tags не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->tags)) {
                $tags_ids = explode(',', $product->tags);

                foreach ($tags_ids as $tags_id) {
                    if(!in_array((int)$tags_id, $tags)) {
                        $this->errors['products'][$products_errors_count] = 'Product tag не был найден в tags xml.'.' Ошибка в строке '.(dom_import_simplexml($product->tags)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // DESCRIPTION RU
            if(!isset($product->description_ru)) {
                $this->errors['tags'][$products_errors_count] = 'Product description_ru не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            }

            // DESCRIPTION RO
            if(!isset($product->description_ro)) {
                $this->errors['tags'][$products_errors_count] = 'Product description_ro не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            }

            // SIZE
            if(!isset($product->size)) {
                $this->errors['products'][$products_errors_count] = 'Product size не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->size) && !empty($product->size->children())) {
                if(!isset($product->size->unit)) {
                    $this->errors['products'][$products_errors_count] = 'Product size unit не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                    $products_errors_count++;
                } else if(empty($product->size->unit)) {
                    $this->errors['products'][$products_errors_count] = 'Product size unit пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->size->unit)->getLineNo());
                    $products_errors_count++;
                } else if((string)$product->size->unit !== 'mm' && (string)$product->size->unit !== 'sm' && (string)$product->size->unit !== 'm') {
                    $this->errors['products'][$products_errors_count] = 'Product size unit должен иметь значение mm, sm or m.'.' Ошибка в строке '.(dom_import_simplexml($product->size->unit)->getLineNo());
                    $products_errors_count++;
                }

                if(!isset($product->size->width)) {
                    $this->errors['products'][$products_errors_count] = 'Product size width не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                    $products_errors_count++;
                }

                if(!isset($product->size->height)) {
                    $this->errors['products'][$products_errors_count] = 'Product size height не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                    $products_errors_count++;
                }
            }

            // FEATURES
            if(!isset($product->features)) {
                $this->errors['products'][$products_errors_count] = 'Product features не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else {
                foreach ($product->features->feature_id as $feature) {
                    if(!in_array($feature, $features)) {
                        $this->errors['products'][$products_errors_count] = 'Product feature не был найден в features xml.'.' Ошибка в строке '.(dom_import_simplexml($feature)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // IMAGES
            if(!isset($product->images)) {
                $this->errors['products'][$products_errors_count] = 'Product images не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(empty($product->images) || empty($product->images->children())) {
                $this->errors['products'][$products_errors_count] = 'Product images пуст.'.' Ошибка в строке '.(dom_import_simplexml($product->images)->getLineNo());
                $products_errors_count++;
            } else {
                foreach ($product->images->image as $image) {
                    if(empty($image)) {
                        $this->errors['products'][$products_errors_count] = 'Product images image пуст.'.' Ошибка в строке '.(dom_import_simplexml($image)->getLineNo());
                        $products_errors_count++;
                    } else if(!preg_match('/^.+\.(jpg|png|jpeg)$/', $image, $m)) {
                        $this->errors['products'][$products_errors_count] = 'Product images image имеет неверный тип файла. Должен быть png, jpg, jpeg.'.' Ошибка в строке '.(dom_import_simplexml($image)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // COLOR ARRAY
            if(!isset($product->color_array)) {
                $this->errors['products'][$products_errors_count] = 'Product color array не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->color_array)) {
                $color_array = explode(',', $product->color_array);

                foreach ($color_array as $article) {
                    if (!in_array($article, $prods)) {
                        $this->errors['products'][$products_errors_count] = 'Product color array product article не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($product->color_array)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // SIZE ARRAY
            if(!isset($product->size_array)) {
                $this->errors['products'][$products_errors_count] = 'Product size array не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->size_array)) {
                $size_array = explode(',', $product->size_array);

                foreach ($size_array as $article) {
                    if (!in_array($article, $prods)) {
                        $this->errors['products'][$products_errors_count] = 'Product size array product article не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($product->size_array)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // SET
            if(!isset($product->set)) {
                $this->errors['products'][$products_errors_count] = 'Product set не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else {
                foreach ($product->set->id_product as $p) {
                    if(!in_array($p, $prods)) {
                        $this->errors['products'][$products_errors_count] = 'Product set product не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($p)->getLineNo());
                        $products_errors_count++;
                    }

                    if((int)$p['in_kit_only'] !== 0 && (int)$p['in_kit_only'] !== 1) {
                        $this->errors['products'][$products_errors_count] = 'Product set product in kit only должен иметь значение 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($p)->getLineNo());
                        $products_errors_count++;
                    }

                    if(isset($product->set->similar_products)) {
                        foreach ($product->set->similar_products as $similar_products) {
                            foreach ($similar_products->id_product as $similar_p) {
                                if(!in_array($similar_p, $prods)) {
                                    $this->errors['products'][$products_errors_count] = 'Product set product не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($similar_p)->getLineNo());
                                    $products_errors_count++;
                                }

                                if((int)$similar_p['in_kit_only'] !== 0 && (int)$similar_p['in_kit_only'] !== 1) {
                                    $this->errors['products'][$products_errors_count] = 'Product set product in kit only атрибут должен иметь значение 1 или 0.'.' Ошибка в строке '.(dom_import_simplexml($similar_p)->getLineNo());
                                    $products_errors_count++;
                                }
                            }
                        }
                    }
                }
            }

            // RELATED ARRAY
            if(!isset($product->related_array)) {
                $this->errors['products'][$products_errors_count] = 'Product related array не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->related_array)) {
                $related_array = explode(',', $product->related_array);

                foreach ($related_array as $article) {
                    if (!in_array($article, $prods)) {
                        $this->errors['products'][$products_errors_count] = 'Product related array product article не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($product->related_array)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }

            // SIMILAR ARRAY
            if(!isset($product->similar_array)) {
                $this->errors['products'][$products_errors_count] = 'Product similar array не существует в товарах. Пожалуйста, проверьте весь products блок еще раз.';
                $products_errors_count++;
            } else if(!empty($product->similar_array)) {
                $similar_array = explode(',', $product->similar_array);

                foreach ($similar_array as $article) {
                    if (!in_array($article, $prods)) {
                        $this->errors['products'][$products_errors_count] = 'Product similar array product article не был найден в products xml block.'.' Ошибка в строке '.(dom_import_simplexml($product->similar_array)->getLineNo());
                        $products_errors_count++;
                    }
                }
            }
        }
    }

    public function validateAdditionalFilenames(array $filenames) : void
    {
        foreach ($filenames as $iteration => $filename) {
            if(!preg_match("/^upload_($this->xml_instances_pattern)\.xml$/", $filename, $m)) {
                $this->errors['bad_additional_filenames'][$iteration] = 'Incorrect filename';
            }
        }
    }

    public function loadAdditionalFiles(array $filenames) {
        $contents = [];

        if(isset($filenames) && count($filenames) > 0) {
            foreach ($filenames as $iteration => $filename) {
                try {
                    $contents[$iteration] = file_get_contents($this->url.'/'.$filename);
                } catch (ErrorException $exception) {
                    $this->errors['additional_filenames_exception'][$iteration] = $exception->getMessage();
                }
            }
        }

        return $contents;
    }

    public function loadAdditionalXMLsContent(array $filenames, array $file_xmls_content) : void
    {
        if(isset($file_xmls_content) && count($file_xmls_content) > 0) {
            foreach ($file_xmls_content as $iteration => $file_xml_content) {
                try {
                    preg_match("/^upload_($this->xml_instances_pattern)\.xml$/", $filenames[$iteration], $additional_current_filename);
                    $this->additional_xmls[$additional_current_filename[1]] = new \SimpleXMLElement($file_xml_content, LIBXML_BIGLINES);
                } catch (Exception $exception) {
                    $this->errors['load_additional_xmls_exception'][$iteration] = $exception->getMessage();
                }
            }
        }
    }
}
