<div class="card-body rounded-0 mb-0">
    <div class="subheader">
                        <span class="{{ $card->getNameSpaceForeground()}}">
                            {!! paste_icon(Str::lower($card->getNameSpaceIcon()));  !!} {{  $card->getNameSpace() }}
                        </span>
    </div>
    <div class="h1 mb-0 me-2">{{$card->first_name}} {{ $card->last_name }} - OVR ({{ $card->overall }})</div>
</div>
@if($card->active_sales()->orderBy('buyout_price')->count() > 0)
    <div class="card-header mt-0">
        <div class="card-title">Live Auctions</div>
    </div>
    <table class="table card-table table-striped">
        <thead>
        <tr>
            <th>
                Ask
            </th>
            <th>
                Buyout
            </th>
            <th>
                Time
            </th>
            <th>
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($card->active_sales()->orderBy('buyout_price')->get() as $auction)
            <tr>
                <td>
                    {{ currency($auction->starting_bid)}}
                </td>
                <td>
                    {{ currency($auction->buyout_price)}}
                </td>
                <td>
                    {{$auction->expired_at->diffForHumans(null,null,true)}}
                </td>
                <td>
                    <a rel="tooltip" class="ml-4 btn btn-sm btn-outline-primary "
                       href="{{$card->get_buy_auction_route($auction)}}" data-original-title=""
                       title="Buy Now">
                                    <span>
                                        {!! paste_icon('shopping-cart') !!} Buy Now
                                    </span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="mt-2">
        <div class="card-header">
            No Live Auctions
        </div>
    </div>
@endif
