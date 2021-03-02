<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>{{ __('order_applied') }}</title>
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

				.content {
					padding: 25px 20px!important;
				}

				.product-card {
					margin: 0 auto;
					max-width: 280px;
				}

				.complect-table,
				.complect-table tr,
				.complect-table td {
					display: block;
					width: 100%!important;
				}

				.complect__img {
					padding-bottom: 0!important;
				}

				.complect__img + td {
					padding: 15px 20px 20px!important;
				}

				.complect-table tr + tr {
					border-top: 1px solid #E7EDF4;
				}

				.complect-table tr + tr>td {
					border-top: none;
				}
			}
		</style>
	</head>
	<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin: 0; padding: 0; color: #252A2E; background-color: #F3F6FB; font-family: 'Open Sans', Arial, sans-serif; font-style: normal; font-weight: normal; line-height: 1.4;">
		<table border="0" cellpadding="0" cellspacing="0" class="main-table" style="margin: 0 auto; width: 600px; border-radius: 3px; overflow: hidden;">
			<thead>
				<tr>
					<td style="text-align: center; line-height: 0;">
						<img width="600" height="120" style="width: 100%; max-width: 100%; height: auto;" src="{{ asset('/public/images/mail/mail-header-1.jpg') }}" alt="Background">
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" class="header-table" style="margin: 0 auto; width: 100%;">
							<tbody>
								<tr>
									<td style="padding: 25px 20px 12px; vertical-align: top;">
										<div class="main-title" style="font-size: 20px; text-transform: uppercase;">
											{{ __('Hello') }}, {{ $order->customer_name }}!
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
						<div class="content" style="padding: 35px 20px; background-color: #fff;">
							<div class="order-title" style="margin-bottom: 15px; color: #252A2E; font-size: 24px; text-transform: uppercase;">
								{{ __('your_order') }} №{{ $order->id }} {{ __('was_applied_successfully') }}.
							</div>
							<div class="content__descr" style="color: #6D7281; font-size: 16px; line-height: 1.2;">
								<p style="margin-bottom: 15px;">{{ __('our_manager_call_you') }}</p>
								<p style="margin-bottom: 15px;">
									{{ __('check_order_status_by_url') }}
									<a href="{{ route('homepage').'/'.$lang.'/'.$order->url }}" target="_blank">{{ route('homepage').'/'.$lang.'/'.$order->url }}</a>
								</p>
								<p style="margin-bottom: 0;">
									{{ __('in_case_any_questions_call_us') }} <br/>
									<a style="margin-top: 4px; display: inline-block; color: #252A2E; vertical-align: baseline; font-weight: 600; font-size: 18px; line-height: 140%; text-transform: uppercase;" href="tel:{{ str_replace([' ', '(', ')'], ['', '', ''], \App\Models\Contact::find(1)->online_shop_phone) }}">
										{{ \App\Models\Contact::find(1)->online_shop_phone }}
									</a>
								</p>
							</div>
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
