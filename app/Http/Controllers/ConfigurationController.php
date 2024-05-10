<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $configuration=Configuration::first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $configuration=Configuration::first();
    }
}
