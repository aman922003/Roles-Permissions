<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingDetail;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function updateDetails(Request $request, ShippingDetail $shippingDetail)
    {
        $data = $request->validate([
            'address' => 'string|required',
            'city'    => 'string|required',
            'state'   => 'string|required',
            'zipcode' => 'string|required',
            'country' => 'string|required',
        ]);

        $shippingDetail->update($data);
        return back()->with('success', 'Shipping details updated.');
    }
}

