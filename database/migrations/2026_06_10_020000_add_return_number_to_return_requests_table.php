<?php

use App\Models\ReturnRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('return_requests', 'return_number')) {
                $table->string('return_number')->unique()->nullable()->after('id');
            }
        });

        ReturnRequest::query()
            ->whereNull('return_number')
            ->orderBy('id')
            ->get()
            ->each(function (ReturnRequest $returnRequest) {
                do {
                    $returnNumber = 'RET-'.$returnRequest->created_at->format('Ymd').'-'.Str::upper(Str::random(6));
                } while (ReturnRequest::where('return_number', $returnNumber)->exists());

                $returnRequest->forceFill(['return_number' => $returnNumber])->save();
            });
    }

    public function down(): void
    {
        Schema::table('return_requests', function (Blueprint $table) {
            if (Schema::hasColumn('return_requests', 'return_number')) {
                $table->dropUnique(['return_number']);
                $table->dropColumn('return_number');
            }
        });
    }
};
