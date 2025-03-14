<strong>APPROVED {{Illuminate\Support\Str::upper($dashboard->type)}}</strong>
<br><br>
Dear {{$user->name}},
<br><br>
We are pleased to inform you that your
@if($dashboard->type == 'projectproposal')
    projectproposal
@else
    request
@endif

has been approved
@if($dashboard->type == 'projectproposal')
    for submission.
@else
    .
@endif

<br>
Below, you will find the details pertaining to the approved request:
<br><br>
<b>RequestID:</b> {{$dashboard->request_id}}
<br><br>
<b>Request Type:</b> {{Illuminate\Support\Str::upper($dashboard->type)}}
<br><br>
<b>Name:</b> {{$dashboard->name}}
<br><br>
<b>Created:</b> {{Carbon\Carbon::createFromTimestamp($dashboard->created)->format('Y-m-d')}}
<br><br>
<b>Approval Date:</b> {{Carbon\Carbon::parse($dashboard->updated_at)->format('Y-m-d')}}
<br><br>
@if($dashboard->type == 'projectproposal')
    With your proposal approved for submission, be sure to manually check its status upon acceptance and report once it has been officially granted.
@else
    With your request approved, this request workflow is now closed. Should you require any further assistance or clarification, please do not hesitate to reach out to: <b>ekonomi@dsv.su.se</b>
@endif

<br><br>
@if($dashboard->type == 'travelrequest')
    Bon Voyage
@endif
<br><br>
---
<br>
This is an automated email, please do not reply to this email.


