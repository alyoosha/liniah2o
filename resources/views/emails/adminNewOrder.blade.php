<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>{{ __('new_order_msg') }} №{{ $order->id }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<style type="text/css">
			@font-face {
				font-family:'Open Sans';
				font-style:normal;
				font-weight:400;
				src:local('Open Sans'), local('OpenSans'),
				url('http://fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
			}

			a {
				opacity: 1;
				transition: opacity ease-in-out .3s;
				text-decoration: none;
			}

			a:hover,
			a:focus {
				opacity: .5;
			}

			.product-card {
				margin: 0 auto;
				max-width: 275px;
			}

			.complect-table {
				border-collapse: separate;
			}

			.complect-table tr + tr>td {
				border-top: 1px solid #E7EDF4;
			}

			@media (max-width: 599px) {
				.main-table {
					width: 100%!important;
				}

				.main-title {
					font-size: 18px!important;
				}

				.header-table {
					position: relative;
					padding-top: 35px;
					padding-bottom: 3px;
					display: block;
				}

				.header-table tr,
				.header-table td {
					display: block;
					width: 100%;
				}

				.header-logo {
					position: absolute;
					top: 15px;
					left: 50%;
					margin-left: -47px;
					padding: 0!important;
					width: 94px;
				}

				.params-table,
				.params-table th,
				.params-table td,
				.params-table tr {
					display: block;
					width: 100%;
				}

				.params-table {
					font-size: 14px!important;
				}

				.params-table td {
					padding-top: 0!important;
				}

				.order {
					padding-top: 25px!important;
				}

				.order-title {
					margin-bottom: 10px!important;
					font-size: 20px!important;
				}

				.order-table,
				.order-table tr,
				.order-table td {
					display: block;
					width: 100%;
				}

				.product-card {
					margin: 0 auto;
					max-width: 280px;
				}
			}
		</style>
	</head>
	<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin: 0; padding: 0; color: #252A2E; background-color: #F3F6FB; font-family: 'Open Sans', Arial, sans-serif; font-style: normal; font-weight: normal; line-height: 1.4;">
		<table border="0" cellpadding="0" cellspacing="0" class="main-table" style="margin: 0 auto; width: 600px; border-radius: 3px; overflow: hidden;">
			<thead>
				<tr>
					<td style="text-align: center; line-height: 0;">
						<img width="600" height="120" style="width: 100%; max-width: 100%; height: auto;" src="{{ asset('/public/images/mail/mail-header-2.jpg') }}" alt="Background">
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" class="header-table" style="margin: 0 auto; width: 100%;">
							<tbody>
								<tr>
									<td style="padding: 25px 20px 12px; vertical-align: top;">
										<div class="main-title" style="font-size: 20px; text-transform: uppercase;">
                                            {{ __('new_order_msg') }} №{{ $order->id }}
										</div>
									</td>
									<td class="header-logo" style="padding: 25px 20px 12px; vertical-align: top; text-align: right; line-height: 0;">
										<a style="color: #252A2E;" href="{{ route('homepage') }}" target="_blank" aria-label="LiniaH2O">
											<img width="94" height="34" style="width: 94px; height: auto;" src="{{ asset('/public/images/mail/logo.png') }}" alt="LiniaH2O">
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="padding: 0 20px;">
						<div style="padding: 25px 10px; background-color: #fff;">
							<table border="0" cellpadding="0" cellspacing="0" class="params-table" style="margin: 0 auto; width: 100%; font-size: 16px; line-height: 120%;">
								<tbody>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('order_status') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->status_display_value }}
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('customer_name') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->customer_name }}
										</td>
									</tr>
									@if((string)$order->payment_method === 'pickup')
										<tr>
											<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                                {{ __('shop_address') }}:
											</th>
											<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
												{{ json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['address'] }}
											</td>
										</tr>
									 @else
									 	<tr>
											<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                                {{ __('delivery_address') }}:
											</th>
											<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
												@php
													if (isset(json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['region'])) {
														$region_id = json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['region'];
													} else $region_id = null;

													$region = \App\Models\Region::find($region_id);

													if (isset(json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['city'])) {
														$city_id = json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['city'];
													} else $city_id = null;

													$city = \App\Models\City::find($city_id);
												@endphp
													@if((string)json_decode($order, JSON_UNESCAPED_UNICODE)['payment'] !== 'in_shop')
													{{ $region ? $region['name_ru'] : '-' }}, {{ $city ? $city['name_ru'] : '-' }}, {{ isset(json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['street']) ? json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['street'] : '-' }}, {{ isset(json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['house']) ? json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['house'] : '-' }}, {{ isset(json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['flat']) ? json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['flat'] : '-' }}
												@else
													Адрес магазина:<br>
													{{ isset(json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['address']) ? json_decode($order->delivery_info, JSON_UNESCAPED_UNICODE)['address'] : '-' }}
												@endif
											</td>
										</tr>
									 @endif
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
											E-mail:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->customer_email }}
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('phone') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->customer_phone }}
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('order_purchased_date') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->created_at }}
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('delivery_type') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
                                            @if($order->delivery_method === 'pickup')
                                                {{ __('pickup_delivery') }}
                                            @else
                                                {{ __('courier_delivery') }}
                                            @endif
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('payment_type') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
                                            @if($order->payment_method === 'card')
                                                {{ __('card_payment_type') }}
                                            @else
                                                {{ __('cash_payment_type') }}
                                            @endif
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('total_order_sum') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->total }}
										</td>
									</tr>
									<tr>
										<th style="padding: 5px 10px; color: #6D7281; font-weight: normal; vertical-align: top;">
                                            {{ __('comment') }}:
										</th>
										<td style="padding: 5px 10px; color: #6D7281; font-weight: 600; vertical-align: top;">
											{{ $order->comment ? $order->comment : '-' }}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
			<tfoot>
                <tr>
                    <td style="padding: 30px 15px 25px;" class="order">
                        <div class="order-title" style="margin-bottom: 15px; color: #252A2E; font-size: 24px; text-transform: uppercase;">
                            {{ __('order_consists_of') }}:
                        </div>
                    @php $products = json_decode($order->products, JSON_UNESCAPED_UNICODE); @endphp
                    @php
                        $non_set_products = [];
                        $set_products = [];
                        $total_sum = 0;

                        foreach($products as $p) {
                            if(!isset($p['products'])) {
                                $non_set_products[] = $p;
                                $total_sum += (float)$p['filtered_price'] * (int)$p['count'];
                            } else {
                                $set_products[] = $p;

                                foreach($p['products'] as $item) {
                                    $total_sum += (float)$item['filtered_price'] * (int)$p['count'];
                                }
                            }
                        }
                    @endphp

                    <!-- Если обычный товар -->
                    @if(count($non_set_products) > 0)
                        @foreach($non_set_products as $non_set_product)
                            <table border="0" cellpadding="0" cellspacing="0" class="complect-table" style="margin: 0 auto 10px; width: 100%; background-color: #fff; overflow: hidden; border-radius: 3px;">
                                <tbody>
                                <tr>
                                    <td class="complect__img" style="padding: 20px; width: 160px; line-height: 0; text-align: center;">
                                        <img style="width: 120px; height: auto; border-radius: 3px;" src="{{ $non_set_product['preview_picture'] }}" alt="{{ __('picture_product') }}">
                                    </td>
                                    <td style="padding: 20px 20px 20px 0; vertical-align: middle;">
                                        <div class="complect__title" style="font-size: 16px; line-height: 120%; text-transform: uppercase;">
                                            {{ $non_set_product['name_'.\Illuminate\Support\Facades\App::getLocale()] }}
                                        </div>
                                        <div class="complect__code" style="padding-bottom: 2px; color: #6D7281; font-size: 14px; line-height: 19px;">
                                            {{ __('articul') }}: {{ $non_set_product['articul'] }}
                                        </div>
                                        <div class="complect__params" style="padding-top: 14px; font-size: 15px; line-height: 20px;">
                                            @if($non_set_product['sizes'])
                                                <div>
                                                    {{ isset(json_decode($non_set_product['sizes'])->width) ? json_decode($non_set_product['sizes'])->width : '' }}
                                                    {{ isset(json_decode($non_set_product['sizes'])->height) ? 'x '.json_decode($non_set_product['sizes'])->height : '' }}
                                                    {{ isset(json_decode($non_set_product['sizes'])->depth) ? 'x '.json_decode($non_set_product['sizes'])->depth : '' }}
                                                    {{ $non_set_product['unit_'.\Illuminate\Support\Facades\App::getLocale()] }}</div>
                                            @endif
                                        </div>
                                        <div class="complect__count" style="padding-top: 5px; font-weight: 600; font-size: 15px; line-height: 20px;">
                                            {{ $non_set_product['count'] }} {{ $non_set_product['unit_'.\Illuminate\Support\Facades\App::getLocale()] }} / {{ (float)$non_set_product['filtered_price'] }} {{ __('currency_name_without_part') }}
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                    <!-- Если комплект -->
                        @if(count($set_products) > 0)
                            @php
                                $set_total_sum = 0;

                                foreach($set_products as $key => $set_product) {
                                    foreach ($set_product['products'] as $p) {
                                        $set_total_sum += (float)$p['filtered_price'];
                                    }
                                }
                            @endphp
                            @foreach($set_products as $set_product)
                                <table border="0" cellpadding="0" cellspacing="0" class="header-table" style="margin: 0 auto; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <td style="padding: 30px 5px 20px; vertical-align: middle;">
                                            <div class="main-title" style="font-size: 20px; text-transform: uppercase;">
                                                {{ __('set') }}:
                                            </div>
                                        </td>
                                        <td style="padding: 30px 5px 20px; vertical-align: middle; text-align: right; line-height: 0;">
                                            <div style="font-weight: 600; font-size: 15px; line-height: 20px;">
                                                {{ $set_product['count'] }}{{ __('pieces_cutted') }} / {{ (float)$set_total_sum }} {{ __('currency_name_without_part') }}
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="complect" style="padding: 0 5px">
                                    <table border="0" cellpadding="0" cellspacing="0" class="complect-table" style="margin: 0 auto; width: 100%; background-color: #fff; overflow: hidden; border-radius: 3px;">
                                        <tbody>
                                        @if(isset($set_product['products']) && count($set_product['products']) > 0)
                                            @foreach($set_product['products'] as $key => $kit_item)
                                                <tr>
                                                    <td class="complect__img" style="padding: 20px; width: 160px; line-height: 0; text-align: center;">
                                                        <img style="width: 120px; height: auto; border-radius: 3px;" src="{{ $kit_item['preview_picture'] }}" alt="{{ __('picture_product') }}">
                                                    </td>
                                                    <td style="padding: 20px 20px 20px 0; vertical-align: middle;">
                                                        <div class="complect__title" style="font-size: 16px; line-height: 120%; text-transform: uppercase;">
                                                            {{ $kit_item['name_'.\Illuminate\Support\Facades\App::getLocale()] }}
                                                        </div>
                                                        <div class="complect__code" style="padding-bottom: 2px; color: #6D7281; font-size: 14px; line-height: 19px;">
                                                            {{ __('articul') }}: {{ $kit_item['articul'] }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                	<td style="padding: 30px 20px 40px; font-size: 24px; text-transform: uppercase;">
                		<span style="font-weight: 600;">{{ __('total') }}:</span> <span>{{(float) $total_sum }} {{ __('currency_name_without_part') }}</span>
                	</td>
                </tr>
				<tr>
					<td style="padding: 10px; color: #fff; background-color: #6D7281; font-size: 12px; line-height: 16px; text-align: center; text-transform: uppercase;">
						<a style="color: #fff;" href="{{ route('homepage') }}" target="_blank">&copy; LiniaH2O</a>
					</td>
				</tr>
			</tfoot>
		</table>
	</body>
</html>
