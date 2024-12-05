<b>PLEASE NOTE! </b>
<br>
<b>ProjectProposal will be in test mode during the period December 15–20, 2024, and all proposals generated during this time are fabricated for testing purposes only.</b>
<br><br>
---
<br>
New Project Proposal Submitted for Review <br><br>
Dear Finacial Officer,
<br><br>
A new <strong>{{Illuminate\Support\Str::upper($dashboard->type)}}</strong> has been submitted and is now available for your review.
Here's a quick overview of the request:
<br><br>
<b>Proposal:</b> {{$dashboard->name}}
<br><br>
<b>Requester:</b> {{$user->name}}
<br><br>
<b>Unit Head:</b> {{$head->name}}
<br><br>
<b>Created:</b> {{Carbon\Carbon::createFromTimestamp($dashboard->created)->toDateTimeString()}}
<br><br>
<b>ProposalID:</b> {{$dashboard->request_id}}
<br><br>
<b>Approved by vice head:</b> {{$dashboard->updated_at}}
<br><br>
You can review the details and take necessary action by accessing the proposal through the following link:
<br><br>
<a href="{{ url('') }}/pp/review/{{$dashboard->request_id}}">Direct link to {{$dashboard->name}}</a>
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
