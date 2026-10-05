<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'from' => 'nullable|date_format:Y-m-d',
            'until' => ['nullable', 'date_format:Y-m-d', ...($request->filled('from') ? ['after_or_equal:from'] : [])],
            'user_id' => 'nullable|integer|min:1',
            'category' => 'nullable|in:Dokumen,Karyawan,Schedule,Export,Revisi',
        ]);
        $logs = ActivityLog::query()
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', \Carbon\Carbon::parse($v, 'Asia/Jakarta')->startOfDay()->setTimezone(config('app.timezone'))))
            ->when($filters['until'] ?? null, fn ($q, $v) => $q->where('created_at', '<', \Carbon\Carbon::parse($v, 'Asia/Jakarta')->addDay()->startOfDay()->setTimezone(config('app.timezone'))))
            ->when($filters['user_id'] ?? null, fn ($q, $v) => $q->where('user_id', $v))
            ->when($filters['category'] ?? null, fn ($q, $v) => $q->where('category', $v))
            ->orderByDesc('created_at')->orderByDesc('id')->paginate(25)->withQueryString();
        $users = ActivityLog::query()->whereNotNull('user_id')->select('user_id')->selectRaw('MAX(user_name) as user_name')->groupBy('user_id')->orderBy('user_name')->get();
        return view('activity-logs.index', compact('logs', 'users'));
    }
}
