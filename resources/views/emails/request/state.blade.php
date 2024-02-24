Notification: <b>Status Update on Your Submitted Request</b><br><br>
Dear {{$user->name}}
<br><br>
We're reaching out to inform you that your <strong>{{Illuminate\Support\Str::upper($dashboard->type)}}</strong> has been processed.
<br><br>
<b>Updated:</b> {{$dashboard->updated_at}}
<br><br>
<b>By:</b> {{$return->name}}
<br><br>
<b>Status:</b>
@switch($dashboard->state)
    @case('manager_returned')
        returned
        @break
    @case('fo_returned')
        returned
        @break
    @case('head_returned')
        returned
        @break
    @case('manager_denied')
        denied
        @break
    @case('fo_denied')
        denied
        @break
    @case('head_denied')
        denied
        @break
@endswitch

<br><br>
Please take a moment to review any associated comments at your earliest convenience by visiting:
<br><br>
<a href="{{ url('') }}">{{url('')}}</a>
<br><br>
Should you have any questions or need further assistance, feel free to reach out to {{$return->name}}. However, please note that this is an automated notification, and replies to this email will not be monitored.
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
