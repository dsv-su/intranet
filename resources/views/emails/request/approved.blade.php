<strong>APPROVED {{Illuminate\Support\Str::upper($dashboard->type)}}</strong>
<br><br>
Dear {{$user->name}},
<br><br>
We are pleased to inform you that your request has been successfully approved.
<br>
Below, you will find the details pertaining to the approved request:
<br><br>
RequestID: {{$dashboard->request_id}}
<br>
Request Type: {{Illuminate\Support\Str::upper($dashboard->type)}}
<br>
Name: {{$dashboard->name}}
<br>
Created: {{Carbon\Carbon::createFromTimestamp($dashboard->created)->toDateTimeString()}}
<br>
Approval Date: {{$dashboard->updated_at}}
<br>
<br>
With your request approved, this request workflow is now closed. Should you require any further assistance or clarification, please do not hesitate to reach out to: ekonomi@dsv.su.se
<br><br>
@if($dashboard->type == 'travelrequest')
    Bon Voyage
@endif
<br><br>
---
<br>
This is an automated email, please do not reply to this email.


