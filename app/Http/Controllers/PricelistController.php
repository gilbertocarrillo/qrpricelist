<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class PricelistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->pricelist) {
            return to_route('home');
        }
        return view('pricelists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'phone:INTERNATIONAL'],
            'whatsapp' => ['nullable', 'phone:INTERNATIONAL'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'facebook' => ['nullable',  'url'],
            'instagram' => ['nullable',  'url'],
            'twitter' => ['nullable',  'url'],
        ]);

        $validated['user_id'] = $request->user()->id;

        // Create pricelist
        $pricelist = Pricelist::create($validated);

        //Store logo and cover
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $path = Storage::putFileAs("{$pricelist->id}", $logo, "logo." . $logo->getClientOriginalExtension());
            $pricelist->logo = $path;
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $path = Storage::putFileAs("{$pricelist->id}", $cover, "cover." . $cover->getClientOriginalExtension());
            $pricelist->cover = $path;
        }

        // Create url
        $app_url = env('APP_URL');
        $url = "{$app_url}/pricelists/view/{$pricelist->id}";
        $pricelist->url = $url;

        // Create qr code and storage
        $qrcode = QrCode::gradient(127, 0, 255, 225, 0, 255, 'diagonal')->size(512)->format('png')->generate("$url?source=qr");
        $path = "{$pricelist->id}/qrcode.png";
        Storage::put($path, $qrcode);
        $pricelist->qrcode = $path;

        // Save pricelist
        $pricelist->save();

        return to_route('home');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pricelist $pricelist)
    {
        $this->authorize('view', $pricelist);

        return view('pricelists.show', compact('pricelist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pricelist $pricelist)
    {
        $this->authorize('update', $pricelist);
        return view('pricelists.edit', compact('pricelist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pricelist $pricelist)
    {
        $this->authorize('update', $pricelist);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'phone:INTERNATIONAL'],
            'whatsapp' => ['nullable', 'phone:INTERNATIONAL'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'facebook' => ['nullable',  'url'],
            'instagram' => ['nullable',  'url'],
            'twitter' => ['nullable',  'url'],
        ]);

        // Delete logo and cover if exist and store new
        if ($request->hasFile('logo')) {
            if ($pricelist->logo) {
                Storage::delete($pricelist->logo);
            }
            $logo = $request->file('logo');
            $path = Storage::putFileAs("{$pricelist->id}", $logo, "logo." . $logo->getClientOriginalExtension());
            $validated['logo'] = $path;
        }

        if ($request->hasFile('cover')) {
            if ($pricelist->cover) {
                Storage::delete($pricelist->cover);
            }
            $cover = $request->file('cover');
            $path = Storage::putFileAs("{$pricelist->id}", $cover, "cover." . $cover->getClientOriginalExtension());
            $validated['cover'] = $path;
        }

        // Update pricelist
        $pricelist->update($validated);

        return to_route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pricelist $pricelist)
    {
        $this->authorize('delete', $pricelist);

        // Delete logo and cover if exist
        if ($pricelist->logo) {
            Storage::delete($pricelist->logo);
        }
        if ($pricelist->cover) {
            Storage::delete($pricelist->cover);
        }
        // Delete qr code
        if ($pricelist->qrcode) {
            Storage::delete($pricelist->qrcode);
        }
        // Delete pricelist
        $pricelist->delete();

        return to_route('home');
    }

    public function display(Request $request, Pricelist $pricelist)
    {
        // Check si has parameter source
        if ($request->has('source')) {
            // Check si source es q
            if ($request->source == 'qr') {
                // increment pricelists scans
                $pricelist->increment('scans');
            }
        }

        return view('pricelists.display', compact('pricelist'));
    }
}
