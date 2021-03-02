@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('basket');
@endphp
@section('title', $title)
@section('description', 'Страница корзины')
@section('keywords', __('basket'))

@section('content')
    <main class="main-content" id="main-content">
        <cart-index
            language="{{ $lang }}"
            homepage_path="{{ $homepage_path }}"
            recommended_products_default="{{ $json_encoded_recommended_products }}"
            catalog_path_default="{{ $storage_path }}"
            order_link_default="{{ $order_link }}"
        ></cart-index>
    </main>
@endsection
