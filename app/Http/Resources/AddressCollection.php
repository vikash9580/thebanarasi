<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\User;

class AddressCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'      => $data->id,
                    'user_id' => $data->user_id,
                    'name'=>   $data->name,
                    'address' => $data->address,
                    'email'=> $data->email,
                    'country' => $data->country,
                    'state' => $data->state,
                    'city' => $data->city,
                    'postal_code' => $data->postal_code,
                    'phone' => $data->phone,
                    'land_mark' => $data->land_mark,
                    'set_default' => $data->set_default,
                    'address_type'=>$data->address_type,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
