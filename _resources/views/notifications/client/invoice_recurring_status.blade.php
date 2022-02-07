<li class="top-notifications">
    <div class="message-center">
        <a href="{{ route('client.invoice-recurring.index') }}">
            <div class="user-img">
                <span class="btn btn-circle btn-warning"><i class="fa fa-money"></i></span>
            </div>
            <div class="mail-contnet">
                <span class="mail-desc m-0">@lang('email.invoiceRecurringStatus.subject')</span>
                <span class="time">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}</span>
            </div>
        </a>
    </div>
</li>
