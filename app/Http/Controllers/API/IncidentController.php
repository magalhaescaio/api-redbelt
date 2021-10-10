<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IncidentModel as Incident;

use Validator;

class IncidentController extends Controller
{
    private $requestExcept = [
        'limit', 
        'order_by', 
        'order', 
        'page', 
        'count', 
        'current_page', 
        'last_page', 
        'next_page_url', 
        'per_page', 
        'previous_page_url', 
        'total', 
        'url', 
        'from', 
        'to', 
    ];
    
    public function index(Request $request) : \Illuminate\Http\JsonResponse
    {
        try {
            $queryStrings = $request->except($this->requestExcept);

            $limit = $request->input('limit') ?: '10';
            $order_by = $request->input('order') ?: 'id';
            $order = $request->input('order_by') ?: 'desc';
            $page = $request->input('page') ?: '1';

            if($limit >= 100) {
                $limit = 100;
            }

            $query = Incident::query();

            if($request->search){
                $columns = ['title', 'description', 'criticality', 'type', 'status', 'created_at'];
                foreach($columns as $column){
                    $query->orWhere($column, 'LIKE', '%' . $request->search . '%');
                }
                
            }

            $query->whereNull('deleted_at');
            $query->orderBy($order_by, $order);
            $query->simplePaginate($limit);

            return response()->json(['data' => $query->paginate($limit)], 200);

        }catch (\Exception $e) {
            return response()->json(['message' => $e->getTraceAsString()], 500);
        }
    }

    public function show($id) : \Illuminate\Http\JsonResponse
    {
        try {
          
            $incident = Incident::where('id', $id)->count();

            if(!$incident){
                return response()->json(['error' => 'Incident number invalid!'], 406);
            }else{
                $incident = Incident::where('id', $id)->firstOrFail();

                return response()->json(['data' => $incident], 200);
            }

        }catch (\Exception $e) {
            return response()->json(['message' => $e->getTraceAsString()], 500);
        }

    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), (new Incident)->rules(), (new Incident)->messages());

            if ($validator->fails()) { 
                return response()->json(['error' => $validator->errors()], 406);
            }

            $incident = new Incident;

            $user = Incident::create([
                'title' => $request->title,
                'description' => $request->description,
                'criticality' => $request->criticality,
                'type' => $request->type,
                'status' => $request->status
            ]);

            return response()->json(['message' => 'Registration completed!'], 200);

        }catch (\Exception $e) {
            return response()->json(['message' => $e->getTraceAsString()], 500);
        }

    }

    public function update(Request $request, $id) : \Illuminate\Http\JsonResponse
    {
       
        try {
          
            $array_update = Array();

            if($request->title){ $array_update['title'] = $request->title; }
            if($request->description){ $array_update['description'] = $request->description; }
            if($request->criticality){ $array_update['criticality'] = $request->criticality; }
            if($request->type){ $array_update['type'] = $request->type; }
            if($request->status || $request->status === "0"){ 
                $array_update['status'] = $request->status;
            }

            $incident = Incident::where('id', $id)->update($array_update);

            return response()->json(['message' => "Incident updated"], 200);

        }catch (\Exception $e) {
            return response()->json(['message' => $e->getTraceAsString()], 500);
        }

    }

    public function destroy($id) : \Illuminate\Http\JsonResponse
    {
        try {
          
            $incident = Incident::where('id', $id)->count();

            if(!$incident){
                return response()->json(['error' => 'Incident number invalid!'], 406);
            }else{
                $incident = Incident::where('id', $id)->delete();

                return response()->json(['message' => 'Incident removed'], 200);
            }

        }catch (\Exception $e) {
            return response()->json(['message' => $e->getTraceAsString()], 500);
        }
    }


}
