<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Orders_model extends Model
{
    use Notifiable;
    protected $table='orders';
    protected $primaryKey='id';
    protected $fillable=['users_id',
        'users_email','company','street1','city','state','zip','country','phone','shipping_charges','coupon_code','coupon_amount',
        'order_status','payment_method','grand_total','quantities','is_completed'];
}
