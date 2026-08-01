<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Assessment;
use App\Models\Document;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'all');
        
        $patients = collect();
        $assessments = collect();
        $documents = collect();
        
        if ($query) {
            if ($type === 'all' || $type === 'patients') {
                $patients = Patient::search($query)->active()->get();
            }
            
            if ($type === 'all' || $type === 'assessments') {
                $assessments = Assessment::whereHas('patient', function ($q) use ($query) {
                    $q->search($query);
                })->get();
            }
            
            if ($type === 'all' || $type === 'documents') {
                $documents = Document::where('file_name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->active()
                    ->get();
            }
        }
        
        return view('search.index', compact('query', 'type', 'patients', 'assessments', 'documents'));
    }
}
