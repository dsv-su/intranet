Review request<br><br>
Dear {{$manager->name}},
<br><br>
A new <strong>{{Illuminate\Support\Str::upper($dashboard->type)}}</strong> has been submitted.
Your attention is kindly requested to review and approve the request. Below are summarized details of the request:
<br><br>
Requester: {{$user->name}}
<br><br>
Created: {{Carbon\Carbon::createFromTimestamp($dashboard->created)->toDateTimeString()}}
<br><br>
Your prompt attention to this matter is vital to ensure that we can promptly address this request and uphold our commitments to the requester.
Please review the request at your earliest convenience by accessing the following link:
<br><br>
<a href="{{ url('') }}">{{url('')}}</a>
<br><br>
Thank you for your prompt attention to this request.
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
