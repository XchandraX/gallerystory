<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\foto;
use Illuminate\Http\Request;
use Exception;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class UploadController extends Controller
{
    /**
     * Tampilkan form upload foto.
     */
    public function create()
    {
        $categories = category::all();
        return view('upload', compact('categories'));
    }

    /**
     * Proses upload satu atau banyak foto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_private'  => 'required|in:public,private',
            'image.*'     => 'required|image|max:2048',
        ]);

        // Get credentials from .env - use whatever variable names you have
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY') ?: env('CLOUDINARY_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET') ?: env('CLOUDINARY_SECRET');
        
        // Debug: Check if credentials are loaded
        if (!$cloudName || !$apiKey || !$apiSecret) {
            $error = "Cloudinary credentials missing. Check your .env file. ";
            $error .= "Cloud Name: " . ($cloudName ? 'set' : 'not set') . ", ";
            $error .= "API Key: " . ($apiKey ? 'set' : 'not set') . ", ";
            $error .= "API Secret: " . ($apiSecret ? 'set' : 'not set');
            return back()->withErrors(['error' => $error]);
        }

        // Configure Cloudinary directly
        try {
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => $cloudName,
                    'api_key' => $apiKey,
                    'api_secret' => $apiSecret
                ],
                'url' => [
                    'secure' => true
                ]
            ]);
            
            $cloudinary = new Cloudinary();
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to configure Cloudinary: ' . $e->getMessage()]);
        }

        $uploadedCount = 0;
        $errors = [];

        foreach ($request->file('image') as $file) {
            try {
                // Upload to Cloudinary using direct SDK
                $uploadResult = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'photos',
                    'public_id' => time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                ]);

                // Get the secure URL from upload result
                $imageUrl = $uploadResult['secure_url'];

                // Save to database
                foto::create([
                    'title'       => $request->title,
                    'category_id' => $request->category_id,
                    'is_private'  => $request->is_private,
                    'image'       => $imageUrl,
                ]);

                $uploadedCount++;
                
            } catch (Exception $e) {
                $errors[] = "Failed to upload {$file->getClientOriginalName()}: " . $e->getMessage();
            }
        }

        if ($uploadedCount > 0) {
            $message = "$uploadedCount photo(s) uploaded successfully!";
            if (!empty($errors)) {
                return back()->with('success', $message)->withErrors(['upload_errors' => $errors]);
            }
            return back()->with('success', $message);
        }

        return back()->withErrors(['error' => 'No photos were uploaded. ' . implode(' ', $errors)]);
    }
}