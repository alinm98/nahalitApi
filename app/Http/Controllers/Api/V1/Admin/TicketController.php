<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\v1\TicketCollection;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    private Ticket $model;

    public function __construct()
    {
        $this->model = new Ticket();

        $this->middleware(checkPermissions::class.":view-ticket")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-ticket")->only(['store']);
        $this->middleware(checkPermissions::class.":update-ticket")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-ticket")->only(['delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():TicketCollection
    {

        /* Get All Tickets */
        $tickets = $this->model->all();
        /* Get All Tickets */

        return new TicketCollection($tickets);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request):TicketResource
    {

        $data = $request->all();

        /* Validate Status Field */
        if($request->has('status')){
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }
        /* Validate Status Field */

        /* Store Ticket */
        $ticket = $this->model->create($data);
        /* Store Ticket */

        return new TicketResource($ticket);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket):TicketResource
    {
        return new TicketResource($ticket);
    }

}
