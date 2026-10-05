<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use App\Models\EmployeeSchedule;

use App\Models\ScheduleAssignment;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

class ScheduleController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | INDEX

    |--------------------------------------------------------------------------

    |

    | Menampilkan halaman schedule berdasarkan:

    | - Rig

    | - Bulan

    | - Tahun

    | - Crew

    | - Search karyawan

    |

    */

    public function index(Request $request)

    {

        $currentYear = (int) date('Y');

        $year = (int) $request->input(

            'year',

            $currentYear

        );

        $month = (int) $request->input(

            'month',

            date('n')

        );

        if ($month < 1 || $month > 12) {

            $month = (int) date('n');

        }

        /*

        |--------------------------------------------------------------------------

        | RIG

        |--------------------------------------------------------------------------

        */

        $rigs = [

            'ARJ-02',

            'ARJ-06',

            'ARJ-07',

            'ARJ-09',

            'ARJ-10',

            'ARJ-11',

            'ARJ-15',

            'CREW SUPPORT',

        ];

        $selectedRig = $request->input(

            'rig',

            'ARJ-15'

        );

        /*

        |--------------------------------------------------------------------------

        | CREW FILTER

        |--------------------------------------------------------------------------

        */

        $selectedCrew = $request->input(

            'crew',

            'ALL'

        );

        /*

        |--------------------------------------------------------------------------

        | VIEW MODE

        |--------------------------------------------------------------------------

        */

        $viewMode = $request->input(

            'view',

            'monthly'

        );

        if (!in_array(

            $viewMode,

            ['monthly', 'yearly'],

            true

        )) {

            $viewMode = 'monthly';

        }

        /*

        |--------------------------------------------------------------------------

        | SEARCH

        |--------------------------------------------------------------------------

        */

        $search = trim(

            (string) $request->input(

                'search',

                ''

            )

        );

        /*

        |--------------------------------------------------------------------------

        | LOAD ASSIGNMENTS

        |--------------------------------------------------------------------------

        */

        $query = ScheduleAssignment::query()

            ->with([

                'employee',

                'schedules' => function ($query) use (

                    $year,

                    $month,

                    $viewMode

                ) {

                    if ($viewMode === 'yearly') {

                        $query

                            ->whereYear(

                                'schedule_date',

                                $year

                            )

                            ->orderBy(

                                'schedule_date'

                            );

                    } else {

                        $query

                            ->whereYear(

                                'schedule_date',

                                $year

                            )

                            ->whereMonth(

                                'schedule_date',

                                $month

                            )

                            ->orderBy(

                                'schedule_date'

                            );

                    }

                },

            ])

            ->where(

                'year',

                $year

            );

        /*

        |--------------------------------------------------------------------------

        | FILTER RIG

        |--------------------------------------------------------------------------

        */

        if ($selectedRig !== '') {

            $query->where(

                'rig',

                $selectedRig

            );

        }

        /*

        |--------------------------------------------------------------------------

        | FILTER CREW

        |--------------------------------------------------------------------------

        */

        if (

            $selectedCrew !== 'ALL'

            &&

            in_array(

                $selectedCrew,

                [

                    'RIG_SUPERINTENDENT',

                    'A',

                    'B',

                    'C',

                ],

                true

            )

        ) {

            $query->where(

                'crew',

                $selectedCrew

            );

        }

        /*

        |--------------------------------------------------------------------------

        | SEARCH EMPLOYEE

        |--------------------------------------------------------------------------

        */

        if ($search !== '') {

            $query->whereHas(

                'employee',

                function ($employeeQuery) use ($search) {

                    $employeeQuery

                        ->where(

                            'nama_lengkap',

                            'like',

                            '%' . $search . '%'

                        )

                        ->orWhere(

                            'nip',

                            'like',

                            '%' . $search . '%'

                        )

                        ->orWhere(

                            'jabatan',

                            'like',

                            '%' . $search . '%'

                        )

                        ->orWhere(

                            'no_telepon',

                            'like',

                            '%' . $search . '%'

                        );

                }

            );

        }

        $assignments = $query

            ->orderByRaw("

                CASE crew

                    WHEN 'RIG_SUPERINTENDENT' THEN 1

                    WHEN 'A' THEN 2

                    WHEN 'B' THEN 3

                    WHEN 'C' THEN 4

                    ELSE 5

                END

            ")

            ->get();

        /*

        |--------------------------------------------------------------------------

        | GROUP BY CREW

        |--------------------------------------------------------------------------

        */

        $groupedAssignments = [

            'RIG_SUPERINTENDENT' => $assignments

                ->where(

                    'crew',

                    'RIG_SUPERINTENDENT'

                )

                ->values(),

            'A' => $assignments

                ->where(

                    'crew',

                    'A'

                )

                ->values(),

            'B' => $assignments

                ->where(

                    'crew',

                    'B'

                )

                ->values(),

            'C' => $assignments

                ->where(

                    'crew',

                    'C'

                )

                ->values(),

        ];

        /*

        |--------------------------------------------------------------------------

        | EMPLOYEES FOR ADD MODAL

        |--------------------------------------------------------------------------

        */

        $employees = Employee::query()

            ->orderBy(

                'nama_lengkap'

            )

            ->get();

        /*

        |--------------------------------------------------------------------------

        | DAYS IN SELECTED MONTH

        |--------------------------------------------------------------------------

        */

        $daysInMonth = Carbon::create(

            $year,

            $month,

            1

        )->daysInMonth;

        /*

        |--------------------------------------------------------------------------

        | YEARS

        |--------------------------------------------------------------------------

        |

        | Tidak hardcode khusus 2026.

        |

        | Contoh:

        | current year = 2026

        | akan tersedia 2024 s/d 2031.

        |

        */

        $minimumYear = min(

            2026,

            $currentYear - 2

        );

        $maximumYear = max(

            $currentYear + 5,

            $year + 2

        );

        $years = range(

            $minimumYear,

            $maximumYear

        );

        return view(

            'schedules.index',

            compact(

                'rigs',

                'selectedRig',

                'selectedCrew',

                'year',

                'month',

                'years',

                'viewMode',

                'search',

                'assignments',

                'groupedAssignments',

                'employees',

                'daysInMonth'

            )

        );

    }

    /*

    |--------------------------------------------------------------------------

    | ADD EMPLOYEE TO SCHEDULE

    |--------------------------------------------------------------------------

    */

    public function export(Request $request)
    {
        $data = $this->index($request)->getData();
        $path = \App\Services\ScheduleExcelExport::write(
            $data['assignments'],
            (int) $data['year'],
            (int) $data['month'],
            $data['viewMode']
        );
        $rig = preg_replace('/[^A-Za-z0-9_-]+/', '-', $data['selectedRig'] ?: 'Semua-Rig');
        $crew = preg_replace('/[^A-Za-z0-9_-]+/', '-', $data['selectedCrew'] ?: 'ALL');
        $period = $data['viewMode'] === 'yearly'
            ? (string) $data['year']
            : sprintf('%04d-%02d', $data['year'], $data['month']);
        return response()->download(
            $path,
            "Schedule-{$rig}-{$crew}-{$period}.xlsx",
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        )->deleteFileAfterSend(true);
    }

    public function storeAssignment(Request $request)

    {

        $validated = $request->validate([

            'employee_id' => ['required', 'exists:employees,id'],

            'rig' => ['required', 'string', 'max:50'],

            'crew' => [

                'required',

                Rule::in([

                    'RIG_SUPERINTENDENT',

                    'A',

                    'B',

                    'C',

                ]),

            ],

            'year' => ['required', 'integer', 'min:2020', 'max:2100'],

            'anchor_date' => ['required', 'date'],

            'anchor_shift' => [

                'required',

                Rule::in(['S', 'M', 'ON', 'OFF']),

            ],

            'anchor_day' => ['required', 'integer', 'min:1', 'max:14'],

        ]);

        $anchorDate = Carbon::parse($validated['anchor_date'])->startOfDay();

        $year = (int) $validated['year'];

        $crew = $validated['crew'];

        $anchorShift = $validated['anchor_shift'];

        $anchorDay = (int) $validated['anchor_day'];

        if ($anchorDate->year !== $year) {

            return back()

                ->withInput()

                ->with('error', 'Tanggal acuan harus berada pada tahun schedule yang dipilih.');

        }

        if ($crew === 'RIG_SUPERINTENDENT') {

            if (!in_array($anchorShift, ['ON', 'OFF'], true)) {

                return back()

                    ->withInput()

                    ->with('error', 'Rig Superintendent hanya menggunakan ON atau OFF.');

            }

            if ($anchorDay > 14) {

                return back()

                    ->withInput()

                    ->with('error', 'Hari siklus Rig Superintendent hanya 1 sampai 14.');

            }

        } else {

            if (!in_array($anchorShift, ['S', 'M', 'OFF'], true)) {

                return back()

                    ->withInput()

                    ->with('error', 'Crew A/B/C hanya menggunakan S, M, atau OFF.');

            }

            if ($anchorDay > 7) {

                return back()

                    ->withInput()

                    ->with('error', 'Hari siklus Crew A/B/C hanya 1 sampai 7.');

            }

        }

        $exists = ScheduleAssignment::query()

            ->where('employee_id', $validated['employee_id'])

            ->where('year', $year)

            ->exists();

        if ($exists) {

            return back()

                ->withInput()

                ->with('error', 'Karyawan tersebut sudah memiliki schedule pada tahun yang dipilih.');

        }

        $assignment = ScheduleAssignment::create([

            'employee_id' => $validated['employee_id'],

            'rig' => $validated['rig'],

            'crew' => $crew,

            'year' => $year,

        ]);

        /*

        |--------------------------------------------------------------------------

        | AUTO ROSTER BERDASARKAN TANGGAL ACUAN

        |--------------------------------------------------------------------------

        |

        | Rig Superintendent:

        | 14 ON -> 14 OFF -> ulang

        |

        | Crew A/B/C:

        | 7 S -> 7 M -> 7 OFF -> ulang

        |

        | anchor_date + anchor_shift + anchor_day menentukan posisi tepat

        | karyawan pada siklus. Generator kemudian menghitung seluruh tanggal

        | pada tahun tersebut, termasuk tanggal SEBELUM anchor_date. Dengan

        | demikian pergantian 31 Desember -> 1 Januari tidak mereset siklus.

        |

        */

        $this->generateRosterForYear(

            $assignment,

            $anchorDate,

            $anchorShift,

            $anchorDay

        );

        return redirect()

            ->route('schedules.index', [

                'rig' => $validated['rig'],

                'year' => $year,

                'month' => $anchorDate->month,

                'crew' => $crew,

                'view' => 'monthly',

            ])

            ->with(

                'success',

                'Karyawan berhasil ditambahkan dan schedule otomatis sudah disusun untuk tahun ' . $year . '.'

            );

    }

    /*

    |--------------------------------------------------------------------------

    | UPDATE ASSIGNMENT

    |--------------------------------------------------------------------------

    |

    | Untuk pindah:

    | - Rig

    | - Crew

    |

    */

    public function updateAssignment(

        Request $request,

        ScheduleAssignment $assignment

    ) {

        $validated = $request->validate([

            'rig' => [

                'required',

                'string',

                'max:50',

            ],

            'crew' => [

                'required',

                Rule::in([

                    'RIG_SUPERINTENDENT',

                    'A',

                    'B',

                    'C',

                ]),

            ],

        ]);

        $assignment->update(

            $validated

        );

        return back()->with(

            'success',

            'Penempatan schedule karyawan berhasil diperbarui.'

        );

    }

    /*

    |--------------------------------------------------------------------------

    | REMOVE EMPLOYEE FROM SCHEDULE

    |--------------------------------------------------------------------------

    */

    public function destroyAssignment(

        ScheduleAssignment $assignment

    ) {

        $assignment->delete();

        return back()->with(

            'success',

            'Karyawan berhasil dihapus dari schedule.'

        );

    }

    /*

    |--------------------------------------------------------------------------

    | SAVE SINGLE DAY

    |--------------------------------------------------------------------------

    |

    | Klik satu kotak:

    |

    | S

    | M

    | ON

    | OFF

    |

    */

    public function saveDay(

        Request $request,

        ScheduleAssignment $assignment

    ) {

        $validated = $request->validate([

            'schedule_date' => [

                'required',

                'date',

            ],

            'shift_code' => [

                'required',

                Rule::in([

                    'S',

                    'M',

                    'ON',

                    'OFF',

                ]),

            ],

        ]);

        $date = Carbon::parse(

            $validated['schedule_date']

        );

        /*

        |--------------------------------------------------------------------------

        | SECURITY / DATA CONSISTENCY

        |--------------------------------------------------------------------------

        |

        | Schedule hanya boleh disimpan ke tahun assignment tersebut.

        |

        */

        if (

            (int) $date->year

            !==

            (int) $assignment->year

        ) {

            return response()->json([

                'success' => false,

                'message' =>

                    'Tanggal schedule tidak sesuai dengan tahun assignment.',

            ], 422);

        }

        $schedule = EmployeeSchedule::updateOrCreate(

            [

                'schedule_assignment_id'

                    => $assignment->id,

                'schedule_date'

                    => $date->format('Y-m-d'),

            ],

            [

                'shift_code'

                    => $validated['shift_code'],

            ]

        );

        return response()->json([

            'success' => true,

            'message' =>

                'Schedule berhasil disimpan.',

            'schedule' => [

                'id'

                    => $schedule->id,

                'date'

                    => $schedule

                        ->schedule_date

                        ->format('Y-m-d'),

                'shift_code'

                    => $schedule->shift_code,

            ],

        ]);

    }

    /*

    |--------------------------------------------------------------------------

    | CLEAR SINGLE DAY

    |--------------------------------------------------------------------------

    */

    public function clearDay(

        Request $request,

        ScheduleAssignment $assignment

    ) {

        $validated = $request->validate([

            'schedule_date' => [

                'required',

                'date',

            ],

        ]);

        EmployeeSchedule::query()

            ->where(

                'schedule_assignment_id',

                $assignment->id

            )

            ->whereDate(

                'schedule_date',

                $validated['schedule_date']

            )

            ->delete();

        return response()->json([

            'success' => true,

            'message' =>

                'Schedule tanggal tersebut berhasil dikosongkan.',

        ]);

    }

    /*

    |--------------------------------------------------------------------------

    | BULK SAVE

    |--------------------------------------------------------------------------

    |

    | Untuk:

    |

    | pilih tanggal 1-14

    | pilih M

    | Apply

    |

    */

    public function bulkSave(

        Request $request,

        ScheduleAssignment $assignment

    ) {

        $validated = $request->validate([

            'dates' => [

                'required',

                'array',

                'min:1',

            ],

            'dates.*' => [

                'required',

                'date',

            ],

            'shift_code' => [

                'required',

                Rule::in([

                    'S',

                    'M',

                    'ON',

                    'OFF',

                ]),

            ],

        ]);

        foreach (

            $validated['dates']

            as

            $scheduleDate

        ) {

            $date = Carbon::parse(

                $scheduleDate

            );

            if (

                (int) $date->year

                !==

                (int) $assignment->year

            ) {

                continue;

            }

            EmployeeSchedule::updateOrCreate(

                [

                    'schedule_assignment_id'

                        => $assignment->id,

                    'schedule_date'

                        => $date->format(

                            'Y-m-d'

                        ),

                ],

                [

                    'shift_code'

                        => $validated[

                            'shift_code'

                        ],

                ]

            );

        }

        return response()->json([

            'success' => true,

            'message' =>

                'Schedule beberapa tanggal berhasil diperbarui.',

        ]);

    }

    /*

    |--------------------------------------------------------------------------

    | BULK CREW

    |--------------------------------------------------------------------------

    |

    | Contoh:

    |

    | Crew A

    | 1 - 7 September

    | S

    |

    | Semua anggota Crew A langsung mendapatkan S.

    |

    */

    public function bulkCrew(

        Request $request

    ) {

        $validated = $request->validate([

            'rig' => [

                'required',

                'string',

                'max:50',

            ],

            'crew' => [

                'required',

                Rule::in([

                    'RIG_SUPERINTENDENT',

                    'A',

                    'B',

                    'C',

                ]),

            ],

            'year' => [

                'required',

                'integer',

                'min:2020',

                'max:2100',

            ],

            'dates' => [

                'required',

                'array',

                'min:1',

            ],

            'dates.*' => [

                'required',

                'date',

            ],

            'shift_code' => [

                'required',

                Rule::in([

                    'S',

                    'M',

                    'ON',

                    'OFF',

                ]),

            ],

        ]);

        $assignments = ScheduleAssignment::query()

            ->where(

                'rig',

                $validated['rig']

            )

            ->where(

                'crew',

                $validated['crew']

            )

            ->where(

                'year',

                $validated['year']

            )

            ->get();

        foreach (

            $assignments

            as

            $assignment

        ) {

            foreach (

                $validated['dates']

                as

                $scheduleDate

            ) {

                $date = Carbon::parse(

                    $scheduleDate

                );

                if (

                    (int) $date->year

                    !==

                    (int) $assignment->year

                ) {

                    continue;

                }

                EmployeeSchedule::updateOrCreate(

                    [

                        'schedule_assignment_id'

                            => $assignment->id,

                        'schedule_date'

                            => $date->format(

                                'Y-m-d'

                            ),

                    ],

                    [

                        'shift_code'

                            => $validated[

                                'shift_code'

                            ],

                    ]

                );

            }

        }

        return response()->json([

            'success' => true,

            'message' =>

                'Schedule crew berhasil diperbarui.',

        ]);

    }

    /*

    |--------------------------------------------------------------------------

    | CONTINUE ALL SCHEDULES TO NEXT YEAR

    |--------------------------------------------------------------------------

    */

    public function continueYear(Request $request)

    {

        $validated = $request->validate([

            'year' => ['required', 'integer', 'min:2020', 'max:2099'],

        ]);

        $sourceYear = (int) $validated['year'];

        $targetYear = $sourceYear + 1;

        $sourceAssignments = ScheduleAssignment::query()

            ->with(['schedules' => function ($query) use ($sourceYear) {

                $query->whereYear('schedule_date', $sourceYear)

                    ->orderBy('schedule_date');

            }])

            ->where('year', $sourceYear)

            ->get();

        if ($sourceAssignments->isEmpty()) {

            return back()->with(

                'error',

                'Belum ada schedule pada tahun ' . $sourceYear . ' yang dapat dilanjutkan.'

            );

        }

        $created = 0;

        $skipped = 0;

        foreach ($sourceAssignments as $sourceAssignment) {

            $exists = ScheduleAssignment::query()

                ->where('employee_id', $sourceAssignment->employee_id)

                ->where('year', $targetYear)

                ->exists();

            if ($exists) {

                $skipped++;

                continue;

            }

            $lastSchedule = EmployeeSchedule::query()

                ->where('schedule_assignment_id', $sourceAssignment->id)

                ->whereDate('schedule_date', '<=', $sourceYear . '-12-31')

                ->orderByDesc('schedule_date')

                ->first();

            if (!$lastSchedule) {

                $skipped++;

                continue;

            }

            $lastDate = Carbon::parse($lastSchedule->schedule_date)->startOfDay();

            $sameShiftDays = 1;

            $cursor = $lastDate->copy()->subDay();

            $maximumBlock = $sourceAssignment->crew === 'RIG_SUPERINTENDENT' ? 14 : 7;

            while ($sameShiftDays < $maximumBlock) {

                $previous = EmployeeSchedule::query()

                    ->where('schedule_assignment_id', $sourceAssignment->id)

                    ->whereDate('schedule_date', $cursor->format('Y-m-d'))

                    ->first();

                if (!$previous || $previous->shift_code !== $lastSchedule->shift_code) {

                    break;

                }

                $sameShiftDays++;

                $cursor->subDay();

            }

            $targetAssignment = ScheduleAssignment::create([

                'employee_id' => $sourceAssignment->employee_id,

                'rig' => $sourceAssignment->rig,

                'crew' => $sourceAssignment->crew,

                'year' => $targetYear,

            ]);

            $this->generateRosterForYear(

                $targetAssignment,

                $lastDate,

                $lastSchedule->shift_code,

                $sameShiftDays

            );

            $created++;

        }

        $message = $created . ' schedule karyawan berhasil dilanjutkan ke tahun ' . $targetYear . '.';

        if ($skipped > 0) {

            $message .= ' ' . $skipped . ' karyawan dilewati karena schedule tahun berikutnya sudah ada atau data akhir tahun belum tersedia.';

        }

        return redirect()

            ->route('schedules.index', [

                'year' => $targetYear,

                'month' => 1,

                'crew' => 'ALL',

                'view' => 'yearly',

            ])

            ->with('success', $message);

    }

    /*

    |--------------------------------------------------------------------------

    | AUTO ROSTER HELPERS

    |--------------------------------------------------------------------------

    */

    private function generateRosterForYear(

        ScheduleAssignment $assignment,

        Carbon $anchorDate,

        string $anchorShift,

        int $anchorDay

    ): void {

        $cycle = $this->rosterCycle($assignment->crew);

        $cycleLength = count($cycle);

        $anchorIndex = $this->anchorCycleIndex(

            $assignment->crew,

            $anchorShift,

            $anchorDay

        );

        $startDate = Carbon::create(

            (int) $assignment->year,

            1,

            1

        )->startOfDay();

        $endDate = Carbon::create(

            (int) $assignment->year,

            12,

            31

        )->startOfDay();

        $rows = [];

        $now = now();

        for (

            $date = $startDate->copy();

            $date->lte($endDate);

            $date->addDay()

        ) {

            $offset = $anchorDate->diffInDays(

                $date,

                false

            );

            $index = $this->positiveModulo(

                $anchorIndex + $offset,

                $cycleLength

            );

            $rows[] = [

                'schedule_assignment_id' => $assignment->id,

                'schedule_date' => $date->format('Y-m-d'),

                'shift_code' => $cycle[$index],

                'created_at' => $now,

                'updated_at' => $now,

            ];

        }

        /*

        | Satu tahun hanya 365/366 row, jadi aman di-upsert sekaligus.

        | Jika tanggal sudah ada, shift_code diperbarui sesuai roster baru.

        */

        EmployeeSchedule::upsert(

            $rows,

            [

                'schedule_assignment_id',

                'schedule_date',

            ],

            [

                'shift_code',

                'updated_at',

            ]

        );

    }

    private function rosterCycle(string $crew): array

    {

        if ($crew === 'RIG_SUPERINTENDENT') {

            return array_merge(

                array_fill(0, 14, 'ON'),

                array_fill(0, 14, 'OFF')

            );

        }

        return array_merge(

            array_fill(0, 7, 'S'),

            array_fill(0, 7, 'M'),

            array_fill(0, 7, 'OFF')

        );

    }

    private function anchorCycleIndex(

        string $crew,

        string $shift,

        int $day

    ): int {

        if ($crew === 'RIG_SUPERINTENDENT') {

            return $shift === 'ON'

                ? $day - 1

                : 14 + ($day - 1);

        }

        return match ($shift) {

            'S' => $day - 1,

            'M' => 7 + ($day - 1),

            'OFF' => 14 + ($day - 1),

            default => 0,

        };

    }

    private function positiveModulo(

        int $value,

        int $modulo

    ): int {

        return (($value % $modulo) + $modulo) % $modulo;

    }

}
