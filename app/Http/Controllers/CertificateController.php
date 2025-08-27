<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Person;
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

        $user = Person::create([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        Certificate::create([
            'public_id' => '',
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

        $person->update($request->only(['name', 'phone']));

        return back()->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy(Certificate $certificate)
    {
        
        $certificate->delete();
        $certificate->person->delete();

        return back()->with('success', 'User dan sertifikat berhasil dihapus!');
    }

    public function viewCertificate()
    {
        
        $url = "";
        return redirect()->away($url);

    }
}
