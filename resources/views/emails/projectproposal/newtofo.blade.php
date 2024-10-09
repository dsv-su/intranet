New Project Proposal Submitted for Review - <b>Action Required</b><br><br>
Dear Finacial Officer,
<br><br>
A new <strong>{{Illuminate\Support\Str::upper($dashboard->type)}}</strong> has been submitted and is now available for your review.
Here's a quick overview of the request:
<br><br>
<b>Application:</b> {{$dashboard->name}}
<br><br>
<b>Requester:</b> {{$user->name}}
<br><br>
<b>Unit Head:</b> {{$head->name}}
<br><br>
<b>Created:</b> {{Carbon\Carbon::createFromTimestamp($dashboard->created)->toDateTimeString()}}
<br><br>
<b>ApplicationID:</b> {{$dashboard->request_id}}
<br><br>
<b>Approved by vice head:</b> {{$dashboard->updated_at}}
<br><br>
You can conveniently review the details and take necessary action by accessing the request through the following link:
<br><br>
<a href="{{ url('') }}">{{url('')}}</a>
<br><br>
Thank you for your prompt attention to this request.
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
