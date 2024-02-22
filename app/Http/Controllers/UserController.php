<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    protected static string $password;

    public function list() {
        $users = User::all();

        return view('user.list', compact('users'));
    }

    public function create() {
        return view('user.create', ['user' => new User()]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $request->validate([
            'userName' => ['required', 'string'],
            'userDocumentNumber' => ['required', 'numeric', 'digits_between:7,12'],
            'userEmail' => ['nullable'],
            'userPhoneNumber' => ['required', 'numeric', 'digits:10'],
            'userOldCode' => ['nullable'],
            'userAddress' => ['required', 'string'],
            'userCity' => ['required', 'string'],
            'userMunicipality' => ['required', 'string'],
        ]);

        $user = new User();

        $user->name = $request->userName;
        $user->document_type = $request->userDocumentType;
        $user->document_number = $request->userDocumentNumber;
        $user->email = $request->userEmail;
        $user->phone_number = $request->userPhoneNumber;
        $user->address = $request->userAddress;
        $user->city = $request->userCity;
        $user->municipality = $request->userMunicipality;
        $user->old_code = $request->userOldCode;
        $user->password = static::$password ??= Hash::make($request->userDocumentNumber);

        $user->save();

        return redirect()->route('user.list');
    }

    public function edit(User $user) {
        return view('user.show', ['mode' => 'edit'], compact('user'));
    }

    public function show(User $user, Invoice $invoice) {
        $invoices = $invoice->getInvoicesByUser($user->id());
        $total_valor_pendiente = '$' . number_format(num: $invoices['total_valor_pendiente'], thousands_separator: '.');
        $total_pagos_realizados = '$' . number_format(num: $invoices['total_pagos_realizados'], thousands_separator: '.');
        $total_facturas = $invoices['total_valor_pendiente'] + $invoices['total_pagos_realizados'];

        unset($invoices['total_valor_pendiente'], $invoices['total_pagos_realizados']);

        return view('user.show', [
            'mode' => 'show',
            'user' => $user,
            'invoices' => $invoices,
            'total_invoices' => $total_valor_pendiente,
            'total_pagos_realizados' => $total_pagos_realizados,
            'total_facturas' => '$' . number_format(num: $total_facturas, thousands_separator: '.')
        ]);
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'editUserName' => ['required', 'string'],
            'editUserPhoneNumber' => ['required', 'numeric'],
            'editUserAddress' => ['required', 'string']
        ]);

        $user->name = $request->editUserName;
        $user->email = $request->editUserEmail;
        $user->phone_number = $request->editUserPhoneNumber;
        $user->address = $request->editUserAddress;
        $user->old_code = $request->editUserOldCode;

        $user->save();

        return redirect()->route('user.list');
    }

    public function import(Request $request)
    {
        $file = $request->file('import_file_users');
        Excel::import(new UsersImport, $file);
        return redirect()->route('user.list')->with('success', 'Usuarios importados exitosamente');
    }
}
