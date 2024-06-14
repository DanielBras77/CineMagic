<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Requests\ConfigurationFormRequest;

class ConfigurationController extends Controller
{

    public function edit()
    {
        $configuration = Configuration::first();
        //$this->authorize('view', $configuration);

        if (!$configuration) {
            return redirect()->route('dashboard')->with('error', 'Configuration not found');
        }

        return view('configurations.edit', compact('configuration'));
    }

    public function update(ConfigurationFormRequest $request)
    {
        $configuration = Configuration::first();

        if (!$configuration) {
            return redirect()->route('dashboard')->with('error', 'Configuration not found');
        }

        $configuration->update($request->validated());
        return redirect()->route('configurations.edit')->with('success', 'Configuration updated successfully');
    }



/*
    public function edit()
    {
        $configuration=Configuration::first();
    }


    public function update(Request $request)
    {
        $configuration=Configuration::first();
    }
        */
}
