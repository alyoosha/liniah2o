<?php


namespace App\Http\Controllers\Api;


use App\Models\Settings;
use Illuminate\Support\Carbon;

class XMLValidator
{
    public function validateXML()
    {
        $filenames = [
            'upload_products.xml',
            'upload_tags.xml',
            'upload_brands.xml',
            'upload_features.xml',
            'upload_price.xml'
        ];

        $errors = [];

        foreach ($filenames as $filename) {
            $validator = new \App\Parser\XMLValidator($filename);
            $validator->validate();

            $errors = array_merge($errors, $validator->errors);
        }

        return $errors;
    }

    public function getXMLLastValidatedAtTimestamps()
    {
        return Carbon::make(get_setting_by_key('xml_last_validated_at'))->isoFormat('LLL');
    }

    public function updateXMLValidationTimestamps()
    {
        $settings = Settings::find(1);

        if($settings) {
            $settings->xml_last_validated_at = Carbon::now()->format('Y-m-d H:i:s');
            $settings->save();
        }
        return Carbon::now()->isoFormat('LLL');
    }
}
