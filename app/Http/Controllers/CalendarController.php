<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Http\Requests\CalendarRequest;
use App\Http\Requests\ReservationRequest;
use App\Repositories\CalendarRepository;
use App\Repositories\Interfaces\CalendarRepositoryInterface;
use App\Reservation;
use http\Env\Response;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    /**
     * @var CalendarRepositoryInterface
     */
    private $calendarRepository;


    /**
     * CalendarController constructor.
     * @param CalendarRepositoryInterface $calendarRepository
     */
    public function __construct(CalendarRepositoryInterface $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    /**
     * @param Request $request
     * @param CalendarRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CalendarRequest $req)
    {
        $calendar = $this->calendarRepository->exist($request->year, $request->month, $request->companyId);

        if ($calendar) {
            return \response()->json(['error' => __('admin.createError')]);
        }

        $req->persist();
        alert()->success('Success', __('admin.createSuccess'))->toToast();

        return response()->json('success');
    }


    /**
     * @param Calendar $calendar
     * @return Calendar
     */
    public function show(Calendar $calendar)
    {
        return $calendar;
    }


    /**
     * @param Request $request
     * @param ReservationRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function reserve(Request $request, ReservationRequest $req)
    {
        $calendar = Calendar::find($request->calendarId);

        if (!Reservation::freeDates($request->dates, $calendar->id)) {

            return \response()->json(['error' => __('welcome.reserveError')]);
        }
        $datesNumber = count(json_decode($calendar['dates'], true));
        $period = $calendar->makePeriod($request->dates, $datesNumber);

        $req->persist($period);
        alert()->success('Success', __('welcome.reserveSuccess'))->toToast();

        return response()->json('success');
    }


    /**
     * @param Request $request
     * @return array
     */
    public function price(Request $request)
    {
        list($period, $price) = $this->calendarRepository->priceAndPeriod($request->dates, $request->calendarId);

        $result = [
            'period' => $period,
            'price' => $price
        ];
        return $result;
    }
}
