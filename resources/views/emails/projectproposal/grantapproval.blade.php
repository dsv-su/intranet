<b>PLEASE NOTE! </b>
<br>
<b>ProjectProposal is currently in test mode, and all created proposals are fictitious and intended for testing purposes only.</b>
<br><br>
---
<br>
To vicehead
<br>
---
<br><br>
Granted Proposal
<br><br>
This is an automated notification to inform you that application for <strong>{{$dashboard->name}}</strong> has been approved.
Please find the relevant details through the following link:

<br><br>
<a href="{{ url('') }}/pp/view/{{$dashboard->request_id}}">Direct link to {{$dashboard->name}}</a>
<br><br>


<br><br>
Here's a quick overview of the proposal:
<br><br>
<b>Proposal:</b> {{$dashboard->name}}
<br><br>
<b>Requester:</b> {{$user->name}}
<br><br>
<b>Created:</b> {{Carbon\Carbon::createFromTimestamp($dashboard->created)->format('Y-m-d')}}
<br><br>
<b>ProposalID:</b> {{$dashboard->request_id}}
<br><br>
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
