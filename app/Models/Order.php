<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $orderItems;

    protected $appends = [
        'full_name',
        'created_at_formatted',
        'total_formatted',
        'plan_name',
        'plan_length',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getPlanNameAttribute()
    {
        if (! $items = $this->getOrderItems()) {
            return 'N/A';
        }
        $plans = [];
        foreach ($items as $item) {
            $plans[] = $item->name;
        }

        return implode(', ', $plans);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getPlanLengthAttribute()
    {
        if (! $items = $this->getOrderItems()) {
            return 'N/A';
        }
        $lengths = [];
        foreach ($items as $item) {
            if ($item->plan) {
                $lengths[] = $item->plan->length;
            }
        }
        if (count($lengths) == 1) {
            return $lengths[0].' days';
        } elseif (count($lengths) > 1) {
            return min($lengths).' to '.max($lengths).' days';
        } else {
            return 'N/A';
        }

        return 'N/A';
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getOrderItems()
    {
        if (! $this->orderItems) {
            $this->orderItems = $this->orderItems()->orderby('id', 'asc')->get();
        }

        return $this->orderItems;
    }

    public function getTax()
    {
        if ($this->tax_code != '') {
            return 0;
        }
        $tax = 0;
        foreach ($this->getOrderItems() as $orderItem) {
            $tax += round((($orderItem->price * $orderItem->quantity) / 100) * 20, 2);
        }

        return $tax;
    }

    public function getSubtotal()
    {
        $subtotal = 0;
        foreach ($this->getOrderItems() as $orderItem) {
            $subtotal += round(($orderItem->price * $orderItem->quantity), 2);
        }

        return number_format($subtotal, 2);
    }

    public function getTotal()
    {
        return number_format(round((float) $this->getSubtotal() + (float) $this->getTax(), 2), 2);
    }

    public function getTotalFormattedAttribute()
    {
        return number_format($this->total / 100, 2);
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }

    public function getIdFormattedAttribute()
    {
        return '#'.(10000000 + $this->id);
    }
}
