<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected $registration;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->registration->limit($request->get('limit'))
            ->get()
            ->map(function ($registration) {
                return [
                    'id'             => $registration->id,
                    'title'          => $registration->title,
                    'registered_on'  => $registration->registered_on->toDateString(),
                    'decorator'      => $registration->decorator,
                    'register_value' => $registration->register_value,
                    'created_at'     => $registration->created_at->toDateTimeString(),
                ];
            });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'decorator'      => 'required|min:2',
            'register_value' => 'required|numeric',
            'title'          => 'required|min:2',
            'registered_on'  => 'required|date',
        ]);

        $registration = $this->registration->create([
            'user_id'        => 1,
            'decorator'      => trim(ltrim($request->get('decorator'), '+')),
            'register_value' => $request->get('register_value'),
            'title'          => $request->get('title'),
            'registered_on'  => $request->get('registered_on'),
        ]);

        // update the users current balance
        $user = \App\Models\User::find(1);
        $totalBalance = $user->current_balance + $request->get('register_value');

        $user->update([
            'current_balance'   => $totalBalance,
            'current_decorator' => $this->formatBalance($totalBalance),
        ]);

        return $this->show($registration->id);
    }

    /**
     * Update a registration and recalculate all registrations.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Registration $registration, Request $request)
    {
        $this->validate($request, [
            'decorator'      => 'required|min:2',
            'register_value' => 'required|numeric',
            'title'          => 'required|min:2',
            'registered_on'  => 'required|date',
        ]);

        // update the registration.
        $registration->update([
            'title'          => $request->get('title'),
            'register_value' => $request->get('register_value'),
            'decorator'      => $request->get('decorator'),
            'registered_on'  => $request->get('registered_on'),
        ]);

        // recalculate the user SUM
        $userBalance = (int) Registration::selectRaw('sum(register_value) as counting')
            ->pluck('counting')
            ->first();

        // @TODO: after the calculation create a decorator (e.g. 2d 8h 30m)
        $user = \App\Models\User::find(1);
        $user->update([
            'current_balance'   => $userBalance,
            'current_decorator' => $this->formatBalance($userBalance),
        ]);

        return $this->show($registration->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // @TODO: fix login
        $user = \App\Models\User::find(1);
        $registration = $this->registration->findOrFail($id);

        return [
            'id'             => $registration->id,
            'title'          => $registration->title,
            'registered_on'  => $registration->registered_on->toDateString(),
            'decorator'      => $registration->decorator,
            'register_value' => $registration->register_value,
            'created_at'     => $registration->created_at->toDateTimeString(),
            'user'           => [
                'balance'   => $user->current_balance,
                'decorator' => $user->current_decorator,
            ],
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($registration = $this->registration->find($id)) {
            $registration->delete();
        }

        return 1;
    }

    /**
     * Format the current balance.
     *
     * @param int $balance
     *
     * @return string
     */
    public function formatBalance(int $balance): string
    {
        $minutesToDays = (60 * 8);

        $days = 0;
        $hours = 0;

        // checkout if thre is more then a day
        if ($balance >= $minutesToDays) {
            $days = floor($balance / $minutesToDays);
        }

        // get hours remaining
        if (($remain = $balance % $minutesToDays) > 0) {
            $hours = floor($remain / 60);
        }

        $minutes = round($balance % 60);

        $format = [];
        if ($days > 0) {
            $format[] = $days . 'd';
        }

        if ($hours > 0) {
            $format[] = $hours . 'h';
        }

        if ($minutes > 0) {
            $format[] = $minutes . 'm';
        }

        return implode(' ', $format);
    }
}
