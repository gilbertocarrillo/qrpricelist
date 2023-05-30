<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use App\Http\Requests\StorePricelistRequest;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Resources\PricelistResource;
use Illuminate\Contracts\Cache\Store;

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
     * Store a newly created resource in storage.
     */
    public function store(StorePricelistRequest $request)
    {
        $validated = $request->validated();

        if ($request->user()->pricelist) {
            return response()->json([
                'message' => 'You already have a pricelist'
            ], 409);
        }

        $validated['user_id'] = $request->user()->id;

        $pricelist = Pricelist::create($validated);

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

        return response()->json([
            'data' => new PricelistResource($pricelist),
        ],  201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pricelist $pricelist)
    {
        $this->authorize('view', $pricelist);
        return response()->json([
            'data' => new PricelistResource($pricelist),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePricelistRequest $request, Pricelist $pricelist)
    {
        $this->authorize('update', $pricelist);

        $validated = $request->validated();

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

        return response()->json([
            'data' => new PricelistResource($pricelist),
        ], 200);

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

        return response()->noContent();
    }
}
