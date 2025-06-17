<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingDetail;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    //Shipping update details
    public function updateDetails(Request $request, ShippingDetail $shippingDetail)
    {
        $data = $request->validate([
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'region'  => ['required', 'string', 'min:2', 'max:100'],
            'city'    => ['required', 'string', 'min:2', 'max:100'],
            'phone'   => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
            'zip' => ['required', 'string', 'min:4', 'max:10'],
            'country' => ['required', 'string', 'min:2', 'max:100'],
        ]);        

        $shippingDetail->update($data);
        return redirect()->route('admin.orders')->with('success', 'Shipping details updated.');
    }
}

