<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
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

    /**
     * @param $user_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesByUser($user_id): \Illuminate\Http\JsonResponse
    {
        $services_by_user = User::find($user_id)->services;
        return response()->json(['services' => $services_by_user]);
    }
}
