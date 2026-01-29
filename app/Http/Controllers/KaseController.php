<?php

namespace App\Http\Controllers;

use App\Models\Kase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? 'user';

        $casesQuery = Kase::with(['vehicle', 'declarant', 'inspections.inspector']);

        if ($request->filled('search')) {
            $search = $request->search;
            $casesQuery->where(function($q) use ($search) {
                $cleanSearch = str_replace('#', '', $search);
                $q->where('id', 'LIKE', "%$cleanSearch%")
                ->orWhereHas('vehicle', function($v) use ($search) {
                    $v->where('plate_no', 'LIKE', "%$search%");
                });
            });
        }

        if ($request->filled('status')) {
            $casesQuery->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $casesQuery->where('priority', $request->priority);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');

        if (!in_array($sortBy, ['id', 'created_at', 'priority'])) {
            $sortBy = 'created_at';
        }
        
        $casesQuery->orderBy($sortBy, $order);

        $all_cases = $casesQuery->paginate(20);

        $stats = $this->getStatsByRole();

        $viewName = $role . '.dashboard';
        if (view()->exists($viewName)) {
            return view($viewName, compact('all_cases', 'request', 'stats'));
        }

        return view('dashboard', compact('all_cases', 'request', 'stats'));
    }

    public function show($id)
    {
        $case = Kase::with([
            'vehicle', 
            'declarant', 
            'consignee', 
            'documents', 
            'inspections.inspector'
        ])->findOrFail($id);

        $role = auth()->user()->role ?? 'generic';
        $viewName = $role . '.show';

        if (!view()->exists($viewName)) {
            return view('kases.show', compact('case'));
        }

        return view($viewName, compact('case'));
    }

    public function update(Request $request, $id)
    {
        $case = Kase::findOrFail($id);
        $user = auth()->user();

        $priority = $request->priority;
        if ($priority === 'medium') {
            $priority = 'normal';
        }

        if (in_array($user->role, ['admin', 'analyst'])) {
            $case->status = $request->status ?? $case->status;
            $case->priority = $priority ?? $case->priority;
            
            if ($request->has('plate_no') && $case->vehicle) {
                $case->vehicle->update(['plate_no' => strtoupper($request->plate_no)]);
            }
        } 
        elseif ($user->role === 'inspector') {
            $case->status = $request->status;
        }
        elseif ($user->role === 'broker' && $case->status === 'new') {
            if ($request->has('plate_no') && $case->vehicle) {
                $case->vehicle->update(['plate_no' => strtoupper($request->plate_no)]);
            }
            $case->origin_country = $request->origin ?? $case->origin_country;
        }

        $case->save();
        return redirect()->back()->with('success', 'Dati veiksmīgi atjaunināti!');
    }

    private function getStatsByRole()
    {
        return [
            'total' => Kase::count(),
            'new' => Kase::where('status', 'new')->count(),
            'urgent' => Kase::where('priority', 'high')->count(),
            'in_inspection' => Kase::where('status', 'in_inspection')->count(),
        ];
    }

    public function track(Request $request)
    {
        $request->validate(['case_id' => 'required|string']);
        $search = $request->input('case_id');

        $result = Kase::where('id', $search)
            ->orWhereHas('vehicle', function($q) use ($search) {
                $q->where('plate_no', $search);
            })->first();

        return view('dashboard', ['search_result' => $result]);
    }

    public function publicIndex()
    {
        return view('dashboard');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        Kase::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('success', 'Ieraksts dzēsts.');
    }

    public function create()
    {
        if (auth()->user()->role !== 'broker') {
            abort(403, 'Tikai brokeri var iesniegt jaunas kravas.');
        }
    return view('kases.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'broker') 
        {
            abort(403, 'Tikai brokeri var iesniegt jaunas kravas.');
        }

        $request->validate([
            'plate_no' => 'required|string|max:20',
            'origin_country' => 'required|string|size:2',
            'destination_country' => 'required|string|size:2',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $vehicle = \App\Models\Vehicle::where('plate_no', strtoupper($request->plate_no))->first();

        if (!$vehicle)
        {
            $lastVehicle = \App\Models\Vehicle::orderBy('id', 'desc')->first();
            $nextVehNum = $lastVehicle ? ((int) str_replace('veh-', '', $lastVehicle->id)) + 1 : 1;
            $vehId = 'veh-' . str_pad($nextVehNum, 6, '0', STR_PAD_LEFT);

            $vehicle = \App\Models\Vehicle::create([
                'id' => $vehId,
                'plate_no' => strtoupper($request->plate_no),
                'country' => strtoupper($request->origin_country),
            ]);
        }

        $lastKase = \App\Models\Kase::orderBy('id', 'desc')->first();

        if ($lastKase) 
        {
            $lastNumber = (int) str_replace('case-', '', $lastKase->id);
        } else {
            $lastNumber = 0;
        }

        $nextNumber = $lastNumber + 1;
        $kaseId = 'case-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        while (\App\Models\Kase::where('id', $kaseId)->exists())
        {
            $nextNumber++;
            $kaseId = 'case-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        }

        $kase = \App\Models\Kase::create([
            'id' => $kaseId,
            'status' => 'new',
            'priority' => 'normal',
            'origin_country' => strtoupper($request->origin_country),
            'destination_country' => strtoupper($request->destination_country),
            'vehicle_id' => $vehicle->id,
            'declarant_id' => auth()->id(),
            'external_ref' => 'REF-' . strtoupper(substr(uniqid(), -6)),
            'arrival_ts' => now()->addDays(2),
            'risk_flags' => [],
        ]);

        if ($request->hasFile('documents'))
        {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('kase_documents/' . $kase->id);
                
                $kase->documents()->create([
                    'id' => 'doc-' . uniqid(), 
                    'case_id' => $kase->id,
                    'filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'category' => 'General Cargo Document',
                    'pages' => 1,
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

    return redirect()->route('dashboard')->with('success', 'Krava reģistrēta ID: ' . $kaseId);
}
}