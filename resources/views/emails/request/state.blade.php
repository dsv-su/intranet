Status Update: Your Submitted Request<br><br>
Dear {{$user->name}}
<br><br>
Your <strong>{{Illuminate\Support\Str::upper($dashboard->type)}}</strong> has been
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

from {{$return->name}}.
<br><br>
Updated: {{$dashboard->updated_at}}
<br><br>
Please review the comments as soon as possible at:
<br><br>
<a href="{{ url('') }}">{{url('')}}</a>
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
