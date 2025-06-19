<b>PLEASE NOTE! </b>
<br>
<b>ProjectProposal is currently in test mode, and all created proposals are fictitious and intended for testing purposes only.</b>
<br><br>
---
<br>
To Registrator
<br>
---
<br><br>

<br><br>
Hereby is the decision letter for application for the project titled <b>{{$dashboard->name}}</b>.
The document is attached to this email for registration and further processing.
<br><br>
Here's a quick overview of the Application:
<br><br>
<b>Application:</b> {{$dashboard->name}}
<br><br>
<b>Principal Investigator:</b> {{$user->name}}
<br><br>
<b>Created:</b> {{Carbon\Carbon::createFromTimestamp($dashboard->created)->format('Y-m-d')}}
<br><br>
<b>ProposalID:</b> {{$dashboard->request_id}}
<br><br>
---
<br>
This is an automated email, please do not reply to this email.
