<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pi extends Model {
	public function user() {
		return $this->belongsTo(User::class);
	}

	public function reseller() {
		return $this->belongsTo(User::class, 'reseller_id');
	}

	public function product() {
		return $this->belongsTo(Product::class, 'product_id');
	}

}
