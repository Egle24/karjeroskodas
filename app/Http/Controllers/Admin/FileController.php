<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\File;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::with('camp')->get()->groupBy('camp_id'); // Group files by camp_id
        $camps = Camp::all(); // Fetch all camps

        return view('admin.files.index', compact('files', 'camps')); // Pass $camps to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'camp_id' => 'required|exists:camps,id',
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf|max:51200', // Each file must be a PDF and max 5MB
        ]);

        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName(); // Get original file name
            $filePath = 'camp_files/' . $fileName; // Path in storage

            // Save the file in the public disk
            Storage::disk('public')->put($filePath, file_get_contents($file));

            // Save file information to the database
            File::create([
                'camp_id' => $request->input('camp_id'), // Associate with camp
                'file_path' => $filePath, // Path in storage
                'file_name' => $fileName, // Original file name
            ]);
        }

        return redirect()->route('admin.files.index')->with('success', 'Failai sėkmingai įkelti.');
    }

    public function edit($campId)
    {
        $camp = Camp::findOrFail($campId); // Fetch the camp details
        $files = File::where('camp_id', $campId)->get(); // Fetch files for the camp

        // Pass both $camp and $files to the view
        return view('admin.files.edit', compact('files', 'camp'));
    }

    public function update(Request $request, $campId)
    {
        $request->validate([
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:pdf|max:51200', // Each file must be a PDF and max 50MB
            'selected_files' => 'nullable|array',
            'selected_files.*' => 'exists:files,id',
        ]);

        // If files are uploaded
        if ($request->hasFile('files')) {
            $uploadedFiles = $request->file('files');

            // If files are selected for replacement
            if ($request->has('selected_files')) {
                $selectedFiles = $request->input('selected_files');

                foreach ($selectedFiles as $fileId) {
                    $file = File::findOrFail($fileId);

                    // Delete the old file from storage
                    Storage::disk('public')->delete($file->file_path);

                    // Replace with the new uploaded files
                    foreach ($uploadedFiles as $uploadedFile) {
                        $fileName = $uploadedFile->getClientOriginalName();
                        $filePath = 'camp_files/' . $fileName;

                        // Save the new file
                        Storage::disk('public')->put($filePath, file_get_contents($uploadedFile));

                        // Update the existing file's path and name
                        $file->update([
                            'file_path' => $filePath,
                            'file_name' => $fileName,
                        ]);
                    }
                }
            } else {
                // No files selected for replacement, just add the new ones
                foreach ($uploadedFiles as $uploadedFile) {
                    $fileName = $uploadedFile->getClientOriginalName();
                    $filePath = 'camp_files/' . $fileName;

                    // Save the new file in storage
                    Storage::disk('public')->put($filePath, file_get_contents($uploadedFile));

                    // Save the new file in the database
                    File::create([
                        'camp_id' => $campId,
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                    ]);
                }
            }
        }

        return redirect()->route('admin.files.index', $campId)->with('success', 'Failai sėkmingai atnaujinti.');
    }

    public function deleteFiles($campId)
    {
        // Fetch all files associated with the given camp_id
        $files = File::where('camp_id', $campId)->get();
        $camp = Camp::findOrFail($campId); // Retrieve the camp

        // Pass the files and campId to the view
        return view('admin.files.delete', compact('files', 'campId', 'camp'));
    }

    public function destroy(Request $request, $campId)
    {
        $request->validate([
            'selected_files' => 'required|array',
            'selected_files.*' => 'exists:files,id',
        ], [
            'selected_files.required' => 'Nepasirinkote jokių failų.',
            'selected_files.*.exists' => 'Pasirinktas failas nerastas.',
        ]);

        $selectedFiles = $request->input('selected_files');

        $files = File::whereIn('id', $selectedFiles)->where('camp_id', $campId)->get();
        foreach ($files as $file) {
            // Delete file from storage
            Storage::disk('public')->delete($file->file_path);

            // Delete file record from database
            $file->delete();
        }

        return redirect()->route('admin.files.index', $campId)->with('success', 'Pasirinkti failai sėkmingai pašalinti.');
    }

}
