<?php

namespace App\Observers;

use App\Models\Orders;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusLinkObserver
{
    public function saved(Orders $order)
    {
        if(!$order->wasChanged('status')) {
            Mail::send('emails.orderPurchased', ['order' => $order], function ($m) use ($order) {
                $m->from('admin@gmail.com', get_setting_by_key('company_name'));

                $m->to($order->customer_email, $order->customer_name)->subject(__('order_applied'));
            });

            Mail::send('emails.adminNewOrder', ['order' => $order], function ($m) use ($order) {
                $m->from('liniah20@linia.md', get_setting_by_key('company_name'));

                $m->to(config('mail.mail_admin_email'), get_setting_by_key('company_name'))->subject(__('new_order_msg'));

//            $m->attach(asset('storage/'.get_setting_by_key('site_logo')));
            });
        }
    }
}
