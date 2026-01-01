<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // pending のときだけ attendance_id が残る式に UNIQUE を貼る
        DB::statement("
            CREATE UNIQUE INDEX uniq_pending_attendance_expr
            ON stamp_correction_requests (
                (CASE WHEN status = 'pending' THEN attendance_id ELSE NULL END)
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX uniq_pending_attendance_expr ON stamp_correction_requests");
    }
};
