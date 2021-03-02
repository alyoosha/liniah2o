@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('checkout_order');
@endphp
@section('title', $title)
@section('description', __('checkout_order') ?? '')
@section('keywords', __('checkout_order'))

@section('content')
    <cart-order
        language="{{ $lang }}"
        back_to_cart_link="{{ route('pages.cart.index') }}"
        cart_link="{{ route('pages.cart.index') }}"
        homepage_link="{{ route('homepage').'/'.$lang }}"
        recommended_products_default="{{ $json_encoded_recommended_products }}"
        delivery_phone_default="{{ $delivery_phone }}"
        online_phone_default="{{ $online_phone }}"
        available_delivery_regions_default="{{ $regions }}"
    ></cart-order>
@endsection
