@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('catalog').' '.__('collection').' '.$category_collection['name_'.$lang];
@endphp
@section('title', $title)
@section('description', __('catalog').' '.__('collection').' '.$category_collection['name_'.$lang])
@section('keywords', __('catalog').' '.__('collection').' '.$category_collection['name_'.$lang])

@section('content')
    <catalog-collections
        language="{{ $lang }}"
        link_to_main_catalog_page="{{ route('pages.catalog.index') }}"
        link_to_secondary_catalog_page="{{ route('pages.catalog.secondary_index', [$first_slug]) }}"
        category_collection="{{ $category_collection }}"
        first_level_slug="{{ $first_slug }}"
        tile_collections_default="{{ $tile_collections }}"
        default_collection="{{ $collection_list }}"
        slides="{{ $slides }}"
        brands_default="{{ $brands }}"
        countries_default="{{ $countries }}"
        feature_types_default="{{ $feature_types }}"
        feature_types_default="{{ $feature_types }}"
        additional_products_url="{{ $additional_products_url }}"
    ></catalog-collections>
@endsection
