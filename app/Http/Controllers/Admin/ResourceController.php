<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resource;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewResourceRequest;
use Illuminate\Support\Facades\File;
use Request;
use Storage;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            Resource::take(100)->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NewResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewResourceRequest $request)
    {
        $validated = $request->validated();

        // Store the file
        if ($request->resource_type == 'file') {
            $validated['file'] = $validated['file'] = $this->saveFileFromRequest($request, 'file');
        }

        $resource = Resource::create($validated);

        return response()->json($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NewResourceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewResourceRequest $request, $id)
    {
        $validated = $request->validated();

        // Store the file
        if ($request->resource_type == 'file') {
            $validated['file'] = $this->saveFileFromRequest($request, 'file');
        }

        $resource = Resource::query()
            ->where('id', $id)
            ->update($validated);

        return response()->json($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Resource::where('id', $id)->delete();

        return response()->json([
            'message' => $deleted ? 'Deleted' : 'The resource was not found'
        ]);
    }


    /**
     * Download the file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $resource = Resource::find($id);

        if (! $resource || ! Storage::exists($resource->file)) {
            return response()->json([
                'errors' => [
                    'The file is not found'
                ]
                ], 422);
        }

        return Storage::download($resource->file);
    }

    /**
     * Saves the file to our storage and returns the filename
     *
     * @param  \App\Http\Requests\NewResourceRequest  $request
     * @return string
     */
    private function saveFileFromRequest(NewResourceRequest $request, string $input_name): string
    {
        $filename = $request->file($input_name)->hashName();

        $request->file($input_name)->storeAs(
            null, $filename
        );

        return $filename;
    }
}
