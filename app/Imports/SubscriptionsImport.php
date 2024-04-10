<?php

namespace App\Imports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubscriptionsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $subscription = new Subscription();

        $subscription->service = $row['service'];
        $subscription->user_id = $row['user_id'];
        $subscription->status = $row['status'];

        return $subscription;
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
