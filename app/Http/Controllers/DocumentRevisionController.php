<?php

namespace App\Http\Controllers;

use App\Services\DocumentRevision;
use Illuminate\Http\Request;

class DocumentRevisionController extends Controller
{
    public function index()
    {
        return view('document-revisions.index', [
            'revisions' => DocumentRevision::all(),
            'types' => DocumentRevision::TYPES,
        ]);
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (DocumentRevision::TYPES as $type => $label) {
            $rules["revisions.$type.rev_date"] = ['required', 'date_format:Y-m-d'];
            $rules["revisions.$type.rev_no"] = ['required', 'string', 'max:10', 'regex:/^[0-9]+$/'];
        }
        $validated = $request->validate($rules);
        $values = [];
        foreach (DocumentRevision::TYPES as $type => $label) {
            $values[$type] = [
                'rev_date' => $validated['revisions'][$type]['rev_date'],
                'rev_no' => $validated['revisions'][$type]['rev_no'],
            ];
        }
        DocumentRevision::save($values);
        return redirect()->route('document-revisions.index')
            ->with('success', 'Revisi disimpan. Dokumen baru akan memakai nilai ini.');
    }
}
