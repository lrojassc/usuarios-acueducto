<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Inactivar servicio del suscriptor
     *
     * @param Request $request
     * @param Subscription $subscription
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, Subscription $subscription)
    {
        $service_id = $request->json(['id']);
        $service = $subscription::find($service_id);
        $service->status = 'INACTIVO';
        $service->save();
        return response()->json(['success' => 'Servicio eliminado']);
    }
}
