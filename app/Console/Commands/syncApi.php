<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Party;
use App\Models\Kase;
use App\Models\Document;
use App\Models\Inspection;

class syncApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ja laipni palūgsi, varbūt ielikšu db api prikolus :)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
            
            $response = Http::timeout(30)->get('https://deskplan.lv/muita/app.json');

            $data = $response->json();
            
            $this->syncVehicles($data['vehicles'] ?? []);
            $this->syncParties($data['parties'] ?? []);
            $this->syncKases($data['cases'] ?? []);
            $this->syncUsers($data['users'] ?? []);
            $this->syncDocuments($data['documents'] ?? []);
            $this->syncInspections($data['inspections'] ?? []);
 
    }

    public function syncVehicles(array $vehicles): void
    {
        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['id' => $vehicle['id']],
                [
                    'plate_no' => $vehicle['plate_no'] ?? null,
                    'country'  => $vehicle['country'] ?? null,
                    'make'     => $vehicle['make'] ?? null,
                    'model'    => $vehicle['model'] ?? null,
                    'vin'      => $vehicle['vin'] ?? null,
                ]
            );
        }
    }

    public function syncParties(array $parties): void
    {
        foreach ($parties as $party) {
            Party::updateOrCreate(
                ['id' => $party['id']],
                [
                    'name' => $party['name'] ?? null,
                    'type' => $party['type'] ?? 'unknown',
                    'reg_code' => $party['reg_code'] ?? null,  
                    'country' => $party['country'] ?? null,
                    'email' => $party['email'] ?? null,      
                    'phone' => $party['phone'] ?? null,       
                    'vat' => $party['vat'] ?? null,           
]
            );
        }
    }

    public function syncKases(array $kases): void
    {
        foreach ($kases as $kase) {
            Kase::updateOrCreate(
                ['id' => $kase['id']],
                [
                    'external_ref' => $kase['external_ref'] ?? null,
                    'status' => in_array($kase['status'] ?? '', ['new','screening','in_inspection','on_hold','released','closed']) ? $kase['status'] : 'new',
                    'priority' => $kase['priority'] ?? 'normal',
                    'arrival_ts' => $kase['arrival_ts'] ?? null,
                    'checkpoint_id' => $kase['checkpoint_id'] ?? null,
                    'origin_country' => $kase['origin_country'] ?? null,
                    'destination_country' => $kase['destination_country'] ?? null,
                    'risk_flags' => $kase['risk_flags'] ?? [],
                    'vehicle_id' => $kase['vehicle_id'] ?? null,
                    'declarant_id' => $kase['declarant_id'] ?? null,
                    'consignee_id' => $kase['consignee_id'] ?? null,
                ]
            );
        }
    }

   public function syncUsers(array $users): void
{
    foreach ($users as $user) {
        \App\Models\User::updateOrCreate(
            ['id' => $user['id']], 
            [
                'username'  => $user['username'] ?? null,
                'full_name' => $user['full_name'] ?? null,
                'role'      => $user['role'] ?? 'broker',
                'active'    => $user['active'] ?? true,
                'email'     => ($user['username'] ?? 'user' . $user['id']) . '@RHL.lv',
                'password'  => Hash::make('qwe'),
            ]
        );
    }
}

    public function syncDocuments(array $documents): void
    {
        foreach ($documents as $document) {
            Document::updateOrCreate(
                ['id' => $document['id']],
                [
                    'case_id' => $document['case_id'] ?? null,
                    'filename' => $document['filename'] ?? null,
                    'mime_type' => $document['mime_type'] ?? null,
                    'category' => $document['category'] ?? null,
                    'pages' => $document['pages'] ?? null,
                    'uploaded_by' => $document['uploaded_by'] ?? null,
                ]   
            );
        }
    }

    public function syncInspections(array $inspections): void
    {
        foreach ($inspections as $inspection) {
        
            $result = null;
            if (!empty($inspection['checks']) && is_array($inspection['checks'])) {
                
                $result = $inspection['checks'][0]['result'] ?? null;
                
                $checksData = $inspection['checks'] ?? null;
            } else {
                $checksData = null;
            }
            
            
            $inspectionId = $inspection['id'] ?? null;
            if (empty($inspectionId)) {
                $inspectionId = 'insp-' . ($inspection['case_id'] ?? 'unknown') . '-' . time() . '-' . $count;
            }
            
            Inspection::updateOrCreate(
                ['id' => $inspectionId],
                [
                    'case_id' => $inspection['case_id'] ?? null,
                    'type' => $inspection['type'] ?? null,
                    'result' => $result,
                    'checks' => $checksData, 
                    'started_at' => $inspection['start_ts'] ?? null,
                    'assigned_to' => $inspection['assigned_to'] ?? null,
                    'location' => $inspection['location'] ?? null,
                ]
            );
        }
    }
}
