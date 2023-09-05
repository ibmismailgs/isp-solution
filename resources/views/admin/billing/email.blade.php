<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
    <div class="col-sm-5">
    <h5 style="color:#3393FF">Company Info..</h5>
    <div>Issue Date : <strong>{{ date('d M Y') }}</strong> </div>
    <div>WLT ISP Service</div>
    <div>House# 23/A, Road #3/C</div>
    <div>Sector# 9, Uttara-1230</div>
</div>

    @foreach ($details as $user)
    <div class="col-sm-7">
        <h5 style="color:#3393FF">Client Info..</h5>
        <div>
            Name: <strong>{{ $user->subscribers->name }} </strong>
        </div>
        <div>Subscriber ID: <strong>{{ $user->subscribers->subscriber_id }}</strong>  </div>
        <div>Using Package: <strong>{{  $user->packages->name  }} </strong> </div>
        <div>Package Amount: <strong>{{ $user->packages->amount }} </strong> </div>
        <div>Billing Month: <strong>{{ $user->billing_month }} </strong> </div>
        <div>Used Days: <strong>{{ $user->used_day }} </strong> </div>
        @if( $user->add_sub == 1)
            <div>Additional Amount: <strong>{{ $user->adjust_bill }} </strong> </div>
            @elseif($user->add_sub == 2)
            <div>Discount Amount: <strong>{{ $user->adjust_bill }} </strong> </div>
            @else
        @endif
        <div>Used Amount: <strong>{{ $user->used_amount }} </strong> </div>
        <div>Total Bill: <strong>{{ $user->total_amount }} </strong> </div>
        <div>Phone: <strong>{{ $user->subscribers->contact_no }} </strong> </div>
        <div>Email: <strong>{{ $user->subscribers->email }} </strong> </div>
        <div>Address: <strong>{{ $user->subscribers->address }}</strong> </div>
    </div>
    @endforeach
    </div>
</div>
</div>

