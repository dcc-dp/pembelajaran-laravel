<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Person;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('person')->latest()->get();
        return view('certificate.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Create user
        $user = Person::create([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        // Auto generate certificate
        Certificate::create([
            'public_id' => uniqid() . '-' . $request->phone,
            'person_id' => $user->id,
        ]);

        return back()->with('success', 'User berhasil ditambahkan dan sertifikat telah dibuat!');
    }

    public function edit(Person $person)
    {
        return response()->json($person);
    }

    public function update(Request $request, Person $person)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($request->hasFile('certificate_file')) {
            $certificate = Certificate::where('person_id', $person->id)->first();

            $cloudinary = new Cloudinary();

            $deletedPublic_id = "certificates/" . $certificate->public_id;

            $cloudinary->uploadApi()->destroy($deletedPublic_id, [
                'resource_type' => 'image'
            ]);

            $FileUploaded = $cloudinary->uploadApi()->upload(
                $request->file('certificate_file')->getRealPath(),
                [
                    'folder' => 'certificates',
                    'public_id' => $certificate->public_id,
                    'overwrite' => true,
                    'invalidate' => true,
                ]
            );

            $certificate->version = $FileUploaded['version'];
            $certificate->save();
        }

        $person->update($request->only(['name', 'phone']));

        return back()->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy(Certificate $certificate)
    {
        $cloudinary = new Cloudinary();

        $deletedPublic_id = "certificates/" . $certificate->public_id;
        $cloudinary->uploadApi()->destroy($deletedPublic_id, [
            'resource_type' => 'image'
        ]);
        
        $certificate->delete();
        $certificate->person->delete();

        return back()->with('success', 'User dan sertifikat berhasil dihapus!');
    }

    public function viewCertificate($public_id)
    {

        $certificate = Certificate::where('public_id', $public_id)->first();
        if (empty($certificate->version)) {
            abort(404, 'Sertifikat tidak ditemukan.');
        } else {
            $url = "https://res.cloudinary.com/duxhehco6/image/upload/v{$certificate->version}/certificates/{$certificate->public_id}";
            return redirect()->away($url);
        }
    }
}
