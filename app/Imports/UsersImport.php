<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private static string $password;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User();

        $user->name = $row['name'];
        $user->document_type = $row['document_type'];
        $user->document_number = $row['document_number'];
        $user->email = $row['email'];
        $user->phone_number = $row['phone_number'];
        $user->paid_subscription = $row['paid_subscription'];
        $user->full_payment = $row['full_payment'];
        $user->address = $row['address'];
        $user->city = $row['city'];
        $user->municipality = $row['municipality'];
        $user->password = static::$password ??= Hash::make($row['document_number']);
        $user->status = $row['status'];

        return $user;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
